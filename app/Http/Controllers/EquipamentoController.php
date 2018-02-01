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
    public function store()
    {
        // dd(request()->all());
        $mensagem = ['macaddress.regex' => 'O Formato do MAC ADDRESS tem que ser xx:xx:xx:xx:xx:xx"'];
        $this->validate(request(), ['macaddress' => 'regex:/([a-fA-F0-9]{2}[:]?){6}/'], $mensagem);
        Equipamento::create(request()->all());

        // Melhorar este redirecionamento...
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
        // return $contacts;
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
