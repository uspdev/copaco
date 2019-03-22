<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Carbon\Carbon;
use App\Rede;
use App\User;
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
     * Cuida efetivamente da persistência
     *
     * @param   \App\Equipamento
     * @param   \Illuminate\Http\Request    $request
     * @return  [\App\Equipamento, string]
    */
    private function persisteEquipamento(Equipamento $equipamento, Request $request)
    {
        $erro = '';
        $request->validate([
            'patrimonio' => ['nullable', new Patrimonio],
            'macaddress' => ['required', 'unique:equipamentos,macaddress,'.$equipamento->id, new MacAddress],
            'vencimento' => 'nullable|date_format:"d/m/Y"|after:today',
            'ip' => 'nullable|ip',
        ]);

        /* aqui lidamos com o usuário */
        $user = Auth::user();
        if (Gate::allows('admin')) {
            $user_id = $request->user_id;

            /* se o usuário não existir, criamos
               TODO: validar NUSP e obter esses dados do replicado
            */
            if (!User::where('id',$user_id)->first()) {
                $u = new User;
                $u->id = $user_id;
                $u->name = $user_id;
                $u->email = $user_id."@usp.br";
                $u->save();
            }
        }
        else {
            $user_id = $user->id;
        }

        /*  aqui a gente lida com obtenção de IP */
        $ip = $request->ip;
        $rede_id = $request->rede_id;
        /*  se estiver vazio, será falso */
        $fixarip = $request->fixarip ? $request->fixarip : 0;

        if (!$fixarip) {
            $ip = null;
        }

        $redes = $user->redesComAcesso();
        if (!$redes->contains('id', $rede_id)) {
            $rede_id = null;
            $ip = null;
        }

        /*  na primeira vez, trocaremos da rede vazia para alguma
            ou não mexeremos com rede, pois '' != 0 devolve false

            neste momento:
                $ip == null => alocar automático
                $ip != null => tentar alocar $ip
        */
        $cadastra = false;

        /* cadastra se redes diferentes */
        if ($equipamento->rede_id != $rede_id) {
            $cadastra = true;
        }
        /* ou se ips diferentes dado redes iguais */
        elseif ($equipamento->ip != $ip) {
            $cadastra = true;
        }

        if ($cadastra) {
            $aloca = NetworkOps::aloca($rede_id, $ip);
            if (empty($aloca['danger'])) {
                $rede_id = $aloca['rede'];
                $ip = $aloca['ip'];
            }
            else {
                $erro = $aloca['danger'];
                $rede_id = null;
                $ip = null;
            }
        }

        /*  tratamento da data de vencimento. default: 10 anos
            TODO: colocar no .env um default e usar de lá.
        */
        if (empty(trim($request->vencimento))) {
            $vencimento = Carbon::now()->addYears(10);
        }
        else {
            $vencimento = Carbon::createFromFormat('d/m/Y', $request->vencimento);
        }

        /* persistência (na ordem do formulário) */
        $equipamento->naopatrimoniado = $request->naopatrimoniado;
        $equipamento->patrimonio = $request->patrimonio;
        $equipamento->descricaosempatrimonio = $request->descricaosempatrimonio;
        $equipamento->macaddress = $request->macaddress;
        $equipamento->local = $request->local;

        $equipamento->vencimento = $vencimento;
        $equipamento->rede_id = $rede_id;
        $equipamento->fixarip = $fixarip;
        $equipamento->ip = $ip;
        $equipamento->user_id = $user_id;
        $equipamento->save();

        $data = [
            'equipamento' => $equipamento,
            'erro' => $erro,
        ];

        return $data;
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

        $resultado = $this->persisteEquipamento(new Equipamento, $request);
        $equipamento = $resultado['equipamento'];
        $erro = $resultado['erro'];
        if ($erro) {
            $request->session()->flash('alert-danger', $erro);
            return redirect("/equipamentos/$equipamento->id/edit");
        }

        // salva equipamento no freeRadius
        if (config('copaco.freeradius_habilitar') && !is_null($equipamento->rede_id)) {
            $this->freeradius->cadastraOuAtualizaEquipamento($equipamento);
        }
        
        $request->session()->flash('alert-success', 'Equipamento cadastrado com sucesso!');
        return redirect("/equipamentos/$equipamento->id");
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

        // mac antigo para o freeradius
        $macaddress_antigo = $equipamento->macaddress;

        $resultado = $this->persisteEquipamento($equipamento, $request);
        $equipamento = $resultado['equipamento'];
        $erro = $resultado['erro'];
        if ($erro) {

            $request->session()->flash('alert-danger', $erro);
            return redirect("/equipamentos/$equipamento->id/edit");
        }

        // atualiza equipamento no freeRadius
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
