<?php

namespace App\Http\Controllers;


use App\Equipamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipamentos = Equipamento::all();
        return view('equipamentos.index',compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipamentos.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $mensagem = ['macaddress.regex' => 'O Formato do MAC ADDRESS tem que ser xx:xx:xx:xx:xx:xx"'];
        $this->validate(request(), ['macaddress' => 'regex:/([a-fA-F0-9]{2}[:]?){6}/'], $mensagem);
      
        Equipamento::create([
          'patrimoniado' => $request->patrimoniado,
          'patrimonio' => $request->patrimonio,
          'descricaonaopatromoniado' => $request->descricaonaopatromoniado,
          'macaddress' => $request->macaddress,
          'local' => $request->local,
          'ip' => $request->ip,
          'rede_id' => $request->rede_id,
          'vencimento' => implode("-",array_reverse(explode('/',$request->vencimento))),
        ]);

        // Melhorar este redirecionamento...
        session()->flash('alert-success', 'Equipamento cadastrado com sucesso!');
        return redirect('/equipamentos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function show(Equipamento $equipamento)
    {
        dd($equipamento)   ;
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
        return view ('equipamentos.edit', compact('equipamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mensagem = ['macaddress.regex' => 'O Formato do MAC ADDRESS tem que ser xx:xx:xx:xx:xx:xx"'];
        $this->validate(request(), ['macaddress' => 'regex:/([a-fA-F0-9]{2}[:]?){6}/'], $mensagem);
        $equipamento = Equipamento::findOrFail($id);

        $equipamento->patrimoniado  = $request->patrimoniado;
        $equipamento->patrimonio    = $request->patrimonio;
        $equipamento->macaddress    = $request->macaddress;
        $equipamento->local         = $request->local;
        $equipamento->vencimento    = Carbon::createFromFormat('d/m/Y', $request->vencimento);
        $equipamento->rede_id       = $request->rede_id;

        try {            
            $equipamento->save();
            $request->session()->flash('alert-success', 'Equipamento atualizado com sucesso!');
            return redirect()->route('equipamentos.index');
        } catch (Exception $e) {
            $request->session()->flash('alert-danger', 'Houve um erro.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipamento $equipamento)
    {
        //
    }
  
}
