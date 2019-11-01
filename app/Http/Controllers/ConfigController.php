<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $configs = Config::all();
        $consumer_deploy_key = config('copaco.consumer_deploy_key');
        return view('config/index',compact('consumer_deploy_key','configs'));
    }

    public function config(Request $request)
    {
        /* Persiste dhcp_global */
        $config = Config::where('key','dhcp_global')->first();
        if(is_null($config)) $config = new Config;
        $config->key = 'dhcp_global';
        $config->value = $request->dhcp_global;
        $config->save();

        /* Persiste dhcp_global */
        $config = Config::where('key','shared_network')->first();
        if(is_null($config)) $config = new Config;
        $config->key = 'shared_network';
        $config->value = $request->shared_network;
        $config->save();

        $request->session()->flash('alert-success', 'Configuração atualizada com sucesso!');
        return redirect("/config");
    }
}
