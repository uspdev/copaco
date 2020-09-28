<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\Rede;
use App\Models\Equipamento;

class Utils
{
    public static function ItensUpdatedAt()
    {
        $rede = Rede::orderBy('updated_at', 'DESC')->first();
        $equipamento = Equipamento::orderBy('updated_at', 'DESC')->first();

        $rede = Carbon::createFromFormat('Y-m-d H:i:s', $rede->updated_at);
        $equipamento = Carbon::createFromFormat('Y-m-d H:i:s', $equipamento->updated_at);

        if($rede->greaterThan($equipamento)){
            return $rede->format('d/m/Y H:i:s');
        }
        return $equipamento->format('d/m/Y H:i:s');
    }

}

