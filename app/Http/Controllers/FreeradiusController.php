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
        $this->middleware('can:admin');
        $this->freeradius = new Freeradius;
    }

    public function sincronize(Request $request)
    {
        if (!config('copaco.freeradius_habilitar')) {
            $request->session()->flash('alert-warning', 'Freeradius não habilitado, nenhuma ação feita!');
            return redirect("/config");
        }

        // Limpa as tabelas
        DB::connection('freeradius')->table('radusergroup')->delete();
        DB::connection('freeradius')->table('radgroupreply')->delete();
        DB::connection('freeradius')->table('radcheck')->delete();

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

