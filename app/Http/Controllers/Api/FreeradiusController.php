<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Rede;
use App\Equipamento;
use App\Config;

use App\Utils\NetworkOps;
use App\Utils\Utils;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

use App\Utils\Freeradius;

class FreeradiusController extends Controller
{

    public function authorize_file(Request $request)
    {
        if ($request->consumer_deploy_key != config('copaco.consumer_deploy_key')) {
            return response('Unauthorized action.', 403);
        }
        $freeradius = new Freeradius;
        $file = $freeradius->file();
        return response($file)->header('Content-Type', 'text/plain');
    }
}