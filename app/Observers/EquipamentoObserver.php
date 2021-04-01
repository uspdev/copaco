<?php

namespace App\Observers;

use App\Models\Equipamento;
use App\Utils\Freeradius;

class EquipamentoObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Equipamento "created" event.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return void
     */
    public function created(Equipamento $equipamento)
    {
        // salva equipamento no freeRadius
        if (config('copaco.freeradius_habilitar') && !is_null($equipamento->rede_id)) {
            Freeradius::cadastraOuAtualizaEquipamento($equipamento);
        }
    }

    /**
     * Handle the Equipamento "updated" event.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return void
     */
    public function updated(Equipamento $equipamento)
    {
        $macaddress_antigo = $equipamento->getOriginal('macaddress');

        // atualiza equipamento no freeRadius
        if (config('copaco.freeradius_habilitar') && !is_null($equipamento->rede_id)) {
            Freeradius::cadastraOuAtualizaEquipamento($equipamento, $macaddress_antigo);
        }
    }

    /**
     * Handle the Equipamento "deleted" event.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return void
     */
    public function deleted(Equipamento $equipamento)
    {
        if (config('copaco.freeradius_habilitar')) {
            Freeradius::deletaEquipamento($equipamento);
        }
    }

    /**
     * Handle the Equipamento "restored" event.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return void
     */
    public function restored(Equipamento $equipamento)
    {
        //
    }

    /**
     * Handle the Equipamento "force deleted" event.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return void
     */
    public function forceDeleted(Equipamento $equipamento)
    {

    }
}
