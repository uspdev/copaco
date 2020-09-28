<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Rede;
use App\Rules\MultiplesIP;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $redes = Rede::all();
        $configs = Config::all();
        $consumer_deploy_key = config('copaco.consumer_deploy_key');
        return view('config/index',compact('consumer_deploy_key','configs','redes'));
    }

    public function config(Request $request)
    {
        $keys = ['dhcp_global','shared_network','unique_iprede','unique_gateway','unique_cidr','ips_reservados'];
        
        foreach($keys as $key) {

            if($key == 'unique_iprede' || $key == 'unique_gateway') {
                $request->validate([
                    $key => ['ip'],
                ]);
            }

            if($key == 'unique_cidr') {
                $request->validate([
                    $key => 'required|numeric|min:8|max:30', 
                ]);
            }

            if($key == 'ips_reservados') {
                $request->validate([
                    $key => [new MultiplesIP('DNS')],
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
