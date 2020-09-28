<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Equipamento;

class EquipamentoController extends Controller
{

    /* Esse método não está bom... mas por ora resolve */
    public function ip(Request $request, $patrimonio)
    {
        if($request->consumer_deploy_key != config('copaco.consumer_deploy_key'))
        {
            return response('Unauthorized action.', 403);
        }

        $equipamento = Equipamento::where('patrimonio', $patrimonio)->first();

        if (is_null($equipamento)) {
            return 'não';
        }

        if (is_null($equipamento->ip)) {
            return 'não';
        }        

        return $equipamento->ip;
    }
}
