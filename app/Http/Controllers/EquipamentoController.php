<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\ExcelExport;

use App\Equipamento;
use App\Rede;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\EquipamentoRequest;
use App\Utils\NetworkOps;
use App\Rules\Patrimonio;
use App\Rules\MacAddress;
use App\Utils\Freeradius;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Uspdev\dadosUsp;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

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
    private function search(){
        $request = request();

        $query = Equipamento::allowed();
        // search terms
        if (!is_null($request->search)) {
            //Busca por responsável
            if (!is_null($request->search)) {
                $searchable_fields = ['macaddress','patrimonio','descricaosempatrimonio','local','ip'];
                $query->where(function($query) use ($request,$searchable_fields) {
                    foreach ($searchable_fields as $field) {
                        $query->orWhere($field, 'LIKE', '%' . $request->search . '%');
                    }
                });
                $query2 = User::where('name', 'LIKE', "%$request->search%")->get();
                foreach($query2 as $q){
                    $query->orWhere('user_id','=', $q->id);
                }
            }
        }
        // Mostra apenas equipamentos sem rede
        if (!is_null($request->naoalocados)) {
            $query->where('ip', '=', null);
        }

        // Mostra apenas equipamentos vencidos
        if (!is_null($request->vencidos)) {
            $query->where('vencimento', '<=', Carbon::now());
        }

        //Mostra apenas os equipamentos selecionados de acordo com a rede
        if (!is_null($request->rede_id)) {
            $query = $query->where('rede_id', $request->rede_id);
        }

        // quando não há registros
        if (!$query->count()) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }

        return $query;
    }

    public function index()
    {
        $equipamentos = $this->search()->paginate(20);
        $redes = Rede::allowed()->get();
        return view(('equipamentos.index'), compact('equipamentos','redes'));
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
        $redes = Rede::allowed()->get();
        return view('equipamentos.create', compact('redes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipamentoRequest $request)
    {
        $this->authorize('equipamentos.create');
        $equipamento = new Equipamento;
        $validated = $request->validated();     
        $resultado = $equipamento->setEquipamento($equipamento, $validated,'store');
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

        $logs = DB::table('equipamentos_changes')->where('equipamento_id', $equipamento->id)->orderBy('when', 'desc')->get();
        $changes = Collection::make([]);
        foreach($logs as $log){
            $user = User::find($log->user_id);
            $changes->push([
                'when' => Carbon::createFromFormat('Y-m-d H:i:s', $log->when)->format('d/m/Y H:i'),
                'username' => $user->username,
                'name' => $user->name
            ]);
        }

/*
        if ($equipamento->naopatrimoniado) {
            $patrimonio = new dadosUsp;
            $xml = $patrimonio->fetchNumpat($equipamento->patrimonio);
            $info_patrimonio = $patrimonio->xml2array($xml);
            $info_patrimonio;
            return view('equipamentos.show', compact('equipamento','changes','info_patrimonio'));
        }
*/
        return view('equipamentos.show', compact('equipamento','changes'));
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
        $redes = Rede::allowed()->get();

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
    public function update(EquipamentoRequest $request, Equipamento $equipamento)
    {
        $this->authorize('equipamentos.update', $equipamento);

        // mac antigo para o freeradius
        $macaddress_antigo = $equipamento->macaddress;
        $validated = $request->validated();     
        $resultado = $equipamento->setEquipamento($equipamento, $validated,'update');
        $equipamento = $resultado['equipamento'];
        $erro = $resultado['erro'];
        // gravar log das mudanças
        DB::table('equipamentos_changes')->insert(
            ['equipamento_id' => $equipamento->id, 'user_id' => Auth::user()->id]
        );

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

    public function excel(Excel $excel){
        /* Falta acertar as permissões */
        $headings = ['patrimonio','descricaosempatrimonio','macaddress','local','vencimento','ip'];
        $equipamentos = $this->search()->get($headings)->toArray();
        $export = new ExcelExport($equipamentos, $headings);
        return $excel->download($export, 'equipamentos.xlsx');
    }


}
