<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Carbon\Carbon;
use App\Rede;
use Illuminate\Http\Request;
use App\Utils\NetworkOps;
use App\Rules\Patrimonio;
use App\Rules\MacAddress;
use App\Utils\Freeradius;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Uspdev\dadosUsp;

class EquipamentoController extends Controller
{
    public $freeradius;

    public function __construct()
    {
        $this->middleware('auth');
        $this->freeradius = new Freeradius;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // todos equipamentos
        $equipamentos = Equipamento::where([]);

        // Filtrar equipamentos só das redes que o usuário tem acesso, com exceção do superAdmin
        if (!Gate::allows('admin')) {
            $user = Auth::user();
            $equipamentos->OrWhere('user_id', '=', $user->id);
            foreach ($user->roles()->get() as $role) {
                if ($role->grupoadmin) {
                    $equipamentos->where(function($query) use ($role, $user) {
                        foreach ($role->redes()->get() as $rede) {
                            $query->OrWhere('rede_id', '=', $rede->id);
                        }
                        $query->OrWhere('user_id', '=', $user->id);
                    });
                }
            }
        }
 
        // search terms
        if (isset($request->search)) {
            $searchable_fields = ['macaddress','patrimonio','descricaosempatrimonio','local'];
            $equipamentos->where(function($query) use ($request,$searchable_fields) {
                foreach ($searchable_fields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $request->search . '%');
                }
            });
        }

        // Mostra apenas equipamentos sem rede
        if (isset($request->naoalocados)) {
            if ($request->naoalocados == 'true')
                $equipamentos->where('ip', '=', null);
        }

        // Mostra apenas equipamentos vencidos
        if (isset($request->vencidos)) {
            if ($request->vencidos == 'true')
                $equipamentos->where('vencimento', '<=', Carbon::now());
        }

        // Dica de ouro para debugar SQL gerado:
        //dd($equipamentos->toSql());

        //
        $equipamentos = $equipamentos->paginate(10);
        if ($equipamentos->isEmpty()) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }

        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('equipamentos.create');

        // Mandar somente as redes que o usuário tem permissão de inserção de equipamentos
        $user = Auth::user();
        $redes = $user->redesComAcesso();
        return view('equipamentos.create', compact('redes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('equipamentos.create');

        // Validações
        $request->validate([
            'patrimonio' => ['nullable', new Patrimonio],
            'ip' => 'nullable|ip',
            'macaddress' => ['required', 'unique:equipamentos', new MacAddress],
            'vencimento' => 'nullable|date_format:"d/m/Y"|after:today',
        ]);

        // Se a opção de fixar ip for falsa, ignorar ip de chegada
        if (!$request->fixarip) {
            $request->ip = null;
        }

        // Se o usuário não permissão na rede, cadastrar sem rede
        $user = Auth::user();
        $redes = $user->redesComAcesso();
        if (!$redes->contains('id', $request->rede_id)) {
            $request->rede_id = null;
            $request->ip = null;
            // flahs comentado, pois está aparecendo quando nenhuma rede é selecionada, abrir issue
            // $request->session()->flash('alert-danger', 'Você não tem permissão nesta rede!');
        }

        // Aloca IP
        $ops = new NetworkOps;
        $aloca = $ops->aloca($request->rede_id, $request->ip);

        if (!empty($aloca['danger'])) {
            $request->session()->flash('alert-danger', $aloca['danger']);
        }

        // Tratamento da data de vencimento
        $equipamento = new Equipamento;
        if (empty(trim($request->vencimento))) {
            $equipamento->vencimento = Carbon::now()->addYears(10);
        } else {
            $equipamento->vencimento = Carbon::createFromFormat('d/m/Y', $request->vencimento);
        }

        // Persistência
        $equipamento->naopatrimoniado = $request->naopatrimoniado;
        $equipamento->patrimonio = $request->patrimonio;
        $equipamento->descricaosempatrimonio = $request->descricaosempatrimonio;
        $equipamento->macaddress = $request->macaddress;
        $equipamento->local = $request->local;
        $equipamento->ip = $aloca['ip'];
        $equipamento->fixarip = $request->fixarip;
        $equipamento->rede_id = $aloca['rede'];
        $equipamento->user_id = \Auth::user()->id;
        $equipamento->save();

        // Salva equipamento no freeRadius
        if (config('copaco.freeradius_habilitar') && !is_null($equipamento->rede_id)) {
            $this->freeradius->cadastraOuAtualizaEquipamento($equipamento);
        }

        if (!empty($aloca['danger'])) {
            $request->session()->flash('alert-danger', $aloca['danger']);
            return redirect("/equipamentos/$equipamento->id/edit");
        } else {
            $request->session()->flash('alert-success', 'Equipamento cadastrado com sucesso!');
            return redirect("/equipamentos/$equipamento->id");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function show(Equipamento $equipamento)
    {
        $this->authorize('equipamentos.view', $equipamento);

        if ($equipamento->naopatrimoniado) {
            $patrimonio = new dadosUsp;
            $xml = $patrimonio->fetchNumpat($equipamento->patrimonio);
            $info_patrimonio = $patrimonio->xml2array($xml);
            $info_patrimonio;
            return view('equipamentos.show', compact('equipamento', 'info_patrimonio'));
        }
        return view('equipamentos.show', compact('equipamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipamento $equipamento)
    {
        $this->authorize('equipamentos.update', $equipamento);

        $user = Auth::user();
        $redes = $user->redesComAcesso();

        $equipamento->vencimento = Carbon::createFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y');
        return view('equipamentos.edit', compact('equipamento', 'redes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipamento $equipamento)
    {
        $this->authorize('equipamentos.update', $equipamento);

        // Validações
        $request->validate([
            'patrimonio' => ['nullable', new Patrimonio],
            'ip' => 'nullable|ip',
            'macaddress' => ['required', new MacAddress],
            'macaddress' => 'unique:equipamentos,macaddress,' . $equipamento->id

        ]);

        // Se a opção de fixar ip for falsa, ignorar ip de chegada
        if (!$request->fixarip) {
            $request->ip = null;
        }

        // Se o usuário não permissão na rede, cadastrar sem
        $user = Auth::user();
        $redes = $user->redesComAcesso();
        if (!$redes->contains('id', $request->rede_id)) {
            $request->rede_id = null;
            $request->ip = null;
            //$request->session()->flash('alert-danger', 'Você não tem permissão nesta rede!');
        }

        // mac antigo para o freeradius
        $macaddress_antigo = $equipamento->macaddress;

        // Tratamento da data de vencimento
        if (empty(trim($request->vencimento))) {
            $equipamento->vencimento = Carbon::now()->addYears(10);
        } else {
            $equipamento->vencimento = Carbon::createFromFormat('d/m/Y', $request->vencimento);
        }

        // Persistência
        $equipamento->naopatrimoniado = $request->naopatrimoniado;
        $equipamento->patrimonio = $request->patrimonio;
        $equipamento->descricaosempatrimonio = $request->descricaosempatrimonio;
        $equipamento->macaddress = $request->macaddress;
        $equipamento->local = $request->local;
        $equipamento->user_id = \Auth::user()->id;
        $equipamento->save();

        // Aloca IP
        $ops = new NetworkOps;
        if (($equipamento->rede_id != $request->rede_id) || $equipamento->ip != $request->ip) {
            $aloca = $ops->aloca($request->rede_id, $request->ip);
            $equipamento->rede_id = $aloca['rede'];
            $equipamento->ip = $aloca['ip'];
            $equipamento->save();

            if (!empty($aloca['danger'])) {
                $request->session()->flash('alert-danger', $aloca['danger']);
                return redirect("/equipamentos/$equipamento->id/edit");
            }
        } else {
            $equipamento->fixarip = $request->fixarip;
            $equipamento->rede_id = $request->rede_id;
            $equipamento->ip = $request->ip;
            $equipamento->save();
        }

        // Salva/update equipamento no freeRadius
        if (config('copaco.freeradius_habilitar') && !is_null($equipamento->rede_id)) {
            $this->freeradius->cadastraOuAtualizaEquipamento($equipamento, $macaddress_antigo);
        }

        $request->session()->flash('alert-success', 'Equipamento atualizado com sucesso!');
        return redirect("/equipamentos/$equipamento->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipamento $equipamento, Request $request)
    {
        $this->authorize('equipamentos.delete', $equipamento);

        // deleta equipamento no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            $this->freeradius->deletaEquipamento($equipamento);
        }

        $equipamento->delete();
        $request->session()->flash('alert-danger', 'Equipamento deletado com sucesso!');
        return redirect()->route('equipamentos.index');
    }
}
