<?php

namespace App\Http\Controllers;

use App\Rede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class RedeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redes = Rede::all();

        return view('redes.index')->with('redes', $redes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('redes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required',
            'iprede'    => 'required|ip',
            'cidr'      => 'required|numeric|min:1|max:32',
            'vlan'      => 'numeric'
        ]);
        
        if ($validator->fails()) {
            return redirect('redes/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->iprede == $request->gateway){
            $request->session()->flash('alert-danger', 'O IP da rede deve ser diferente do Gateway.');
            return back();
        }

        $rede = new Rede;
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;

    	  $this->validate ($request, ['gateway'=>'ip'],['Um Gateway válido é requerido.']);
        $rede->gateway  = $request->gateway;
      
        $rede->ntp      = $request->ntp;
        $rede->netbios   = $request->netbios;
        $rede->cidr     = $request->cidr;
        $rede->vlan     =  $request->vlan;
        $rede->save();
        $request->session()->flash('alert-success', 'Rede cadastrada com sucesso!');
        return redirect()->route('redes.index');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rede  $rede
     * @return \Illuminate\Http\Response
     */
    public function show(Rede $rede)
    {
        return view('redes.show',compact('rede'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rede = Rede::findOrFail($id);
        return view('redes.edit', compact('rede'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required',
            'iprede'    => 'required|ip',
            'cidr'      => 'required|numeric|min:1|max:32'
        ]);
        
        if ($validator->fails()) {
            return redirect("redes/$id/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->iprede == $request->gateway){
            $request->session()->flash('alert-danger', 'O IP da rede deve ser diferente do Gateway.');
            return back();
        }

        $rede = Rede::findOrFail($id);
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;
        $rede->gateway  = $request->gateway;

        $rede->ntp      = $request->ntp;
        $rede->netbios  = $request->netbios;
        $rede->cidr     = $request->cidr;
        $rede->vlan     =  $request->vlan;
     
        $rede->save();
        $request->session()->flash('alert-success', 'Rede atualizada com sucesso!');
        return redirect()->route('redes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rede = Rede::findOrFail($id);
        try {
            $rede->delete();
            return redirect()->route('redes.index')->with('alert-danger', 'Rede deletada!');
        } catch (Exception $e) {
            $request->session()->flash('alert-danger', 'Houve um erro, a rede não foi deletada.');
            return back();
        }
    }
}
