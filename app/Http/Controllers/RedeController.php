<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Rede;

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
        $rede = new Rede;
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;
        $rede->cidr     = $request->cidr;

        try {            
            $rede->save();
            $request->session()->flash('alert-success', 'Rede cadastrada com sucesso!');
            return redirect()->route('redes.index');
        } catch (Exception $e) {
            $request->session()->flash('alert-danger', 'Houve um erro.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $rede = Rede::findOrFail($id);
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;
        $rede->cidr     = $request->cidr;

        try {            
            $rede->save();
            $request->session()->flash('alert-success', 'Rede atualizada com sucesso!');
            return redirect()->route('redes.index');
        } catch (Exception $e) {
            $request->session()->flash('alert-danger', 'Houve um erro.');
            return back();
        }
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
