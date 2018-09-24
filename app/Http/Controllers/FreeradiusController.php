<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Rede;
use App\Equipamento;

use App\Utils\NetworkOps;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;

use App\Utils\Freeradius;

class FreeradiusController extends Controller
{
    public $freeradius;

    public function __construct()
    {
        $this->freeradius = new Freeradius;
    }

    public function file()
    {
        $file = $this->freeradius->file();
        return response($file)->header('Content-Type', 'text/plain');
    }

    public function sincronize(Request $request)
    {
        if( getenv('FREERADIUS_HABILITAR') != 'True' ){
            $request->session()->flash('alert-warning', 'Freeradius não habilitado, nenhuma ação feita!');
            return redirect("/config");
        }

        // Limpa as tabelas
        DB::connection('freeradius')->table('radusergroup')->delete();
        DB::connection('freeradius')->table('radgroupreply')->delete();

        // Re-inseri tudo novamente
        $redes = Rede::all();
        foreach ($redes as $rede) {
            $this->freeradius->cadastraOuAtualizaRede($rede);
            foreach ($rede->equipamentos as $equipamento) {
                $this->freeradius->cadastraOuAtualizaEquipamento($equipamento);
            }
        }
        $request->session()->flash('alert-warning', 'Freeradius sincronizado com sucesso!');
        return redirect("/config");
    }
}

