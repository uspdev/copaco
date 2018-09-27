<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $consumer_deploy_key = env('CONSUMER_DEPLOY_KEY');
        return view('config/index',compact('consumer_deploy_key'));
    }
}
