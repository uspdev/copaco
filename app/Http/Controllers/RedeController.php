<?php

namespace App\Http\Controllers;

use App\Rede;
use App\User;
use App\Config;
use Illuminate\Http\Request;
use App\Http\Requests\RedeRequest;
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
        $redes = Rede::paginate(20);
        return view('redes.index')->with('redes', $redes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shared_networks = Config::where('key','shared_network')->first();
        if(!is_null($shared_networks)){
            $shared_networks = array_map('trim', explode(',', $shared_networks->value));
        } else {
            $shared_networks = ['default'];
        }

        if (!in_array("default", $shared_networks)) 
            array_push($shared_networks, "default");
        
        return view('redes.create',compact('shared_networks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RedeRequest $request)
    {
        // Validações
        $validated = $request->validated();
 
        // Persistência
        $rede = new Rede;
        $validated['user_id'] = \Auth::user()->id;
        $rede = $rede->create($validated);

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
        $shared_networks = Config::where('key','shared_network')->first();
        if(!is_null($shared_networks)){
            $shared_networks = array_map('trim', explode(',',$shared_networks->value));
        } else {
            $shared_networks = ['default'];
        }

        if (!in_array("default", $shared_networks)) 
            array_push($shared_networks, "default");
        
        return view('redes.edit', compact('rede','shared_networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RedeRequest $request, Rede $rede)
    {
        // Validações
        $validated = $request->validated();
 
        // Persistência
        $rede->update($validated);

        // gravar log das mudanças
        DB::table('redes_changes')->insert(
            ['rede_id' => $rede->id, 'user_id' => \Auth::user()->id]
        );

        // Salva/update rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            $this->freeradius->cadastraOuAtualizaRede($rede);
        }

        $request->session()->flash('alert-success', 'Rede atualizada com sucesso!');
        return redirect()->route('redes.show', $rede->id);
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
