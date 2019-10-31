<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipamento;

class EquipamentosApiController extends Controller
{

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
