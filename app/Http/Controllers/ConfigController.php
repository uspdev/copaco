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
        $keys = ['dhcp_global','shared_network','unique_iprede','unique_gateway','unique_cidr'];
        
        foreach($keys as $key) {

            if($key == 'unique_iprede' || $key == 'unique_gateway') {
                $request->validate([
                    $key    => ['ip'],
                ]);
            }

            if($key == 'unique_cidr') {
                $request->validate([
                    $key      => 'required|numeric|min:8|max:30', 
                ]);
            }

            $config = Config::where('key',$key)->first();
            if(is_null($config)) $config = new Config;
            $config->key = $key;
            $config->value = $request->{$key};
            $config->save();
        }

        $request->session()->flash('alert-success', 'Configuração atualizada com sucesso!');
        return redirect("/config");
    }
}
