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

        if (is_null($rede) && is_null($equipamento)) {
            return Carbon::now()->format('d/m/Y H:i:s');
        }

        if (is_null($rede)) {
            return Carbon::parse($equipamento->updated_at)->format('d/m/Y H:i:s');
        }

        if (is_null($equipamento)) {
            return Carbon::parse($rede->updated_at)->format('d/m/Y H:i:s');
        }

        $redeUpdatedAt = Carbon::parse($rede->updated_at);
        $equipamentoUpdatedAt = Carbon::parse($equipamento->updated_at);

        if ($redeUpdatedAt->greaterThan($equipamentoUpdatedAt)) {
            return $redeUpdatedAt->format('d/m/Y H:i:s');
        }

        return $equipamentoUpdatedAt->format('d/m/Y H:i:s');
    }

}

