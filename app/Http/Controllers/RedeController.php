<?php

namespace App\Http\Controllers;

use App\Rede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Rules\DomainOrIp;
use App\Rules\PertenceRede;
use App\Utils\Freeradius;

class RedeController extends Controller
{

    public $freeradius;

    public function __construct()
    {
        $this->middleware('can:admin');
        $this->freeradius = new Freeradius;
    }

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

        // Validações
        $request->validate([
            'nome'      => 'required',
            'iprede'    => 'ip|required|different:gateway',
            'cidr'      => 'required|numeric|min:20|max:30',
            'vlan'      => 'numeric',
            'gateway'   => ['ip','required', new PertenceRede($request->gateway, $request->iprede, $request->cidr)],
            'dns'       => [new DomainOrIp('DNS')],
            'netbios'   => [new DomainOrIp('NetBIOS')],
            'ad_domain' => [new DomainOrIp('Active Directory Domain')],
            'ntp'       => [new DomainOrIp('NTP')],
        ]);    

        // Persistência
        $rede = new Rede;
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;
        $rede->dns      = $request->dns;
        $rede->gateway  = $request->gateway;
        $rede->ntp      = $request->ntp;
        $rede->netbios  = $request->netbios;
        $rede->cidr     = $request->cidr;
        $rede->vlan     = $request->vlan;
        $rede->ad_domain= $request->ad_domain;
        $rede->user_id = \Auth::user()->id;
        $rede->last_modify_by = \Auth::user()->id;
        $rede->save();

        // Salva rede no freeRadius
        if( getenv('FREERADIUS_HABILITAR') == 'True' ){
            $this->freeradius->cadastraOuAtualizaRede($rede);
        }

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
        return view('redes.show', compact('rede'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rede $rede)
    {
        return view('redes.edit', compact('rede'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rede $rede)
    {
        // Validações
        $request->validate([
            'nome'      => 'required',
            'iprede'    => 'ip|required|different:gateway',
            'cidr'      => 'required|numeric|min:20|max:30',
            'vlan'      => 'numeric',
            'gateway'   => ['ip','required', new PertenceRede($request->gateway, $request->iprede, $request->cidr)],
            'dns'       => [new DomainOrIp('DNS')],
            'netbios'   => [new DomainOrIp('NetBIOS')],
            'ad_domain' => [new DomainOrIp('Active Directory Domain')],
            'ntp'       => [new DomainOrIp('NTP')],
        ]);

        // Persistência
        $rede->nome     = $request->nome;
        $rede->iprede   = $request->iprede;
        $rede->gateway  = $request->gateway;
        $rede->dns      = $request->dns;
        $rede->cidr     = $request->cidr;
        $rede->ntp      = $request->ntp;
        $rede->netbios  = $request->netbios;
        $rede->cidr     = $request->cidr;
        $rede->vlan     = $request->vlan;
        $rede->ad_domain= $request->ad_domain;
        $rede->last_modify_by = \Auth::user()->id;
        $rede->touch();
        $rede->save();

        // Salva/update rede no freeRadius
        if( getenv('FREERADIUS_HABILITAR') == 'True' ){
            $this->freeradius->cadastraOuAtualizaRede($rede);
        } 

        $request->session()->flash('alert-success', 'Rede atualizada com sucesso!');
        return redirect()->route('redes.show',['id' =>$rede]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rede $rede)
    {
        // deleta rede no freeRadius
        if( getenv('FREERADIUS_HABILITAR') == 'True' ){
            $this->freeradius->deletaRede($rede);
        } 

        // Desaloca os equipamentos dessa rede 
        foreach ($rede->equipamentos as $equipamento) {
            // deleta equipamentos no freeRadius
            if( getenv('FREERADIUS_HABILITAR') == 'True' ){
                $this->freeradius->deletaEquipamento($equipamento);
            }
            $equipamento->ip = null;
            $equipamento->save();
        }
        $rede->delete();
        return redirect()->route('redes.index')->with('alert-danger', 'Rede deletada!');
    }
}
