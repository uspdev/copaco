<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Carbon\Carbon;
use App\Rede;
use Illuminate\Http\Request;
use App\Utils\NetworkOps;
use App\Rules\Patrimonio;
use App\Rules\MacAddress;

class EquipamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipamentos = Equipamento::all();
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $redes = Rede::all();
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
        // Validações
        $request->validate([
            'patrimonio'    => ['nullable',new Patrimonio],
            'ip'            => 'nullable|ip',
            'macaddress'    => ['required','unique:equipamentos',new MacAddress],
            'vencimento'    => 'nullable|date_format:"d/m/Y"|after:today',
        ]);

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
        $equipamento->last_modify_by = \Auth::user()->id;
        $equipamento->save();

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
        return view('equipamentos.show', compact('equipamento'));
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipamento $equipamento)
    {
        /* Rota gerada pelo laravel:
            http://devserver:porta/equiapmento/{id}/edit
        */
        $equipamento->vencimento = Carbon::createFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y');
        $redes = Rede::all();
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
        // Validações
        $request->validate([
            'patrimonio'    => ['nullable',new Patrimonio],
            'ip'            => 'nullable|ip',
            'macaddress'    => ['required',"unique:equipamentos,id,{{$equipamento->id}}",new MacAddress],
            'vencimento'    => 'nullable|date_format:"d/m/Y"|after:today',
        ]);

        // Persistência
        $equipamento->naopatrimoniado = $request->naopatrimoniado;
        $equipamento->patrimonio = $request->patrimonio;
        $equipamento->descricaosempatrimonio = $request->descricaosempatrimonio;
        $equipamento->macaddress = $request->macaddress;
        $equipamento->local = $request->local;
        $equipamento->vencimento = Carbon::createFromFormat('d/m/Y', $request->vencimento);
        $equipamento->last_modify_by = \Auth::user()->id;
        $equipamento->save();

        // Aloca IP
        $ops = new NetworkOps;
        if (($equipamento->rede_id != $request->rede_id) || $equipamento->ip != $request->ip) {
            $aloca = $ops->aloca($request->rede_id, $request->ip);
            $equipamento->rede_id= $aloca['rede'];
            $equipamento->ip = $aloca['ip'];
            $equipamento->save();
      
            if (!empty($aloca['danger'])) {
                $request->session()->flash('alert-danger', $aloca['danger']);
                return redirect("/equipamentos/$equipamento->id/edit");
            }
        } else {
            $equipamento->fixarip = $request->fixarip;
            $equipamento->rede_id= $request->rede_id;
            $equipamento->ip = $request->ip;
            $equipamento->save();
        }

        $request->session()->flash('alert-success', 'Equipamento cadastrado com sucesso!');
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
        $equipamento->delete();
        $request->session()->flash('alert-danger', 'Equipamento deletado com sucesso!');
        return redirect()->route('equipamentos.index');
    }

    public function search(Request $request)
    {
        $equipamentos = Equipamento::where('macaddress', 'LIKE', '%' . $request->macaddress . '%')->get();
        if ($equipamentos->isEmpty()) {
            $request->session()->flash('alert-danger', 'Não há registros com esta busca.');
        }
        return view('equipamentos.index', compact('equipamentos'));
    }

    public function naoAlocados()
    {
        $equipamentos = Equipamento::WhereNull('ip')->get();
        return view('equipamentos.index', compact('equipamentos'));
    }
}
