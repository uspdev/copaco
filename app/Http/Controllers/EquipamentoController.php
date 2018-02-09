<?php

namespace App\Http\Controllers;


use App\Equipamento;
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
          'naopatrimoniado' => $request->naopatrimoniado,
          'patrimonio' => $request->patrimonio,
          'descricaosempatrimonio' => $request->descricaosempatrimonio,
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
        // 
        $equipamento->vencimento = implode("/",array_reverse(explode('-',$equipamento->vencimento)));
        return view ('equipamentos.edit', compact('equipamento'));
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
        $mensagem = ['macaddress.regex' => 'O Formato do MAC ADDRESS tem que ser xx:xx:xx:xx:xx:xx"'];
        $this->validate(request(), ['macaddress' => 'regex:/([a-fA-F0-9]{2}[:]?){6}/'], $mensagem);
        $eqto = Equipamento::find($equipamento->id)
                    ->update($request->all());
        
        $request->session()->flash('alert-success', 'Equipamento atualizado com sucesso!');
        return redirect('/equipamentos');
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
