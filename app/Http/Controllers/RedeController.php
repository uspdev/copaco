<?php

namespace App\Http\Controllers;

use App\Rede;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Rules\MultiplesIP;
use App\Rules\Domain;
use App\Rules\PertenceRede;
use App\Utils\Freeradius;
use App\Rules\RedeCidr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

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
            'iprede'    => ['ip','required','different:gateway', new RedeCidr($request->cidr)],
            'cidr'      => 'required|numeric|min:8|max:30',
            'vlan'      => 'numeric',
            'gateway'   => ['ip','required', new PertenceRede($request->gateway, $request->iprede, $request->cidr)],
            'dns'       => [new MultiplesIP('DNS')],
            'netbios'   => [new MultiplesIP('NetBIOS')],
            'ad_domain' => [new Domain('Active Directory Domain')],
            'ntp'       => [new MultiplesIP('NTP')],
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
        $rede->save();

        // Salva rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
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
        $logs = DB::table('redes_changes')->where('rede_id', $rede->id)->orderBy('when', 'desc')->get();
        $changes = Collection::make([]);
        foreach($logs as $log){
            $user = User::find($log->user_id);
            $changes->push([
                'when' => Carbon::createFromFormat('Y-m-d H:i:s', $log->when)->format('d/m/Y H:i'),
                'username' => $user->username,
                'name' => $user->name
            ]);
        }
        return view('redes.show', compact('rede','changes'));
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
            // 'iprede'    => ['ip','required','different:gateway', new RedeCidr($request->iprede, $request->cidr, $rede->id)],
            'iprede'    => ['ip','required','different:gateway', new RedeCidr($request->cidr, $rede->id)],
            'cidr'      => 'required|numeric|min:8|max:30',
            'vlan'      => 'numeric',
            'gateway'   => ['ip','required', new PertenceRede($request->gateway, $request->iprede, $request->cidr)],
            'dns'       => [new MultiplesIP('DNS')],
            'netbios'   => [new MultiplesIP('NetBIOS')],
            'ad_domain' => [new Domain('Active Directory Domain')],
            'ntp'       => [new MultiplesIP('NTP')],
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
        $rede->touch();
        $rede->save();

        // gravar log das mudanças
        DB::table('redes_changes')->insert(
            ['rede_id' => $rede->id, 'user_id' => \Auth::user()->id]
        );

        // Salva/update rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            $this->freeradius->cadastraOuAtualizaRede($rede);
        }

        $request->session()->flash('alert-success', 'Rede atualizada com sucesso!');
        return redirect()->route('redes.show', ['id' => $rede]);
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
        if (config('copaco.freeradius_habilitar')) {
            $this->freeradius->deletaRede($rede);
        } 

        // Desaloca os equipamentos dessa rede 
        foreach ($rede->equipamentos as $equipamento) {
            // deleta equipamentos no freeRadius
            if (config('copaco.freeradius_habilitar')) {
                $this->freeradius->deletaEquipamento($equipamento);
            }
            $equipamento->ip = null;
            $equipamento->save();
        }
        $rede->delete();
        return redirect()->route('redes.index')->with('alert-danger', 'Rede deletada!');
    }
}
