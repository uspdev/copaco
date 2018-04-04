<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rede;
use App\Equipamentos;

use App\Utils\NetworkOps;

use IPTools\IP;
use IPTools\Network;
use IPTools\Range;


class FreeradiusController extends Controller
{
    public function build()
    {
        $ops = new NetworkOps;
        $build = "";

        $redes = Rede::all(); 
        foreach($redes as $rede){
            
            if(isset($rede->vlan) && !empty($rede->vlan)) {

                foreach($rede->equipamentos as $equipamento) {
                    $macaddress = strtolower(str_replace(':','',$equipamento->macaddress));
                    $build .= "$macaddress   Cleartext-Password := $macaddress\n";
                    $build .= "    Tunnel-Type = \"VLAN\"\n";
                    $build .= "    Tunnel-Medium-Type = \"IEEE-802\",\n";
                    $build .= "    Tunnel-Private-Group-Id = \"1188\"\n\n";
                }
            }
        }
    
        $build .= "DEFAULT Framed-Protocol == PPP\n";
        $build .= "    Framed-Protocol = PPP,\n";
        $build .= "    Framed-Compression = Van-Jacobson-TCP-IP\n\n";

        $build .= "DEFAULT Hint == \"CSLIP\"\n";
        $build .= "    Framed-Protocol = SLIP,\n";
        $build .= "    Framed-Compression = Van-Jacobson-TCP-IP\n\n";

        $build .= "DEFAULT Hint == \"SLIP\"\n";
        $build .= "    Framed-Protocol = SLIP";

        return response($build)->header('Content-Type', 'text/plain');
    }
}
