<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KeaService;

class KeaController extends Controller
{
    protected $keaService;

    public function __construct(KeaService $keaService)
    {
        $this->keaService = $keaService;
    }

    public function kea(Request $request)
    {
        if ($request->consumer_deploy_key != config('copaco.consumer_deploy_key')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        try {
            $config = $this->keaService->generateKeaConfig();
            return response()->json($config, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uniquekeab(Request $request)
    {
        if ($request->consumer_deploy_key != config('copaco.consumer_deploy_key')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        try {
            $config = $this->keaService->generateUniqueKeaConfig();
            return response()->json($config, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
