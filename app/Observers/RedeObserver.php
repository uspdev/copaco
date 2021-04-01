<?php

namespace App\Observers;

use App\Models\Rede;
use App\Utils\Freeradius;

class RedeObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Rede "created" event.
     *
     * @param  \App\Models\Rede  $rede
     * @return void
     */
    public function created(Rede $rede)
    {
        // Salva rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            Freeradius::cadastraOuAtualizaRede($rede);
        }
    }

    /**
     * Handle the Rede "updated" event.
     *
     * @param  \App\Models\Rede  $rede
     * @return void
     */
    public function updated(Rede $rede)
    {
        // Salva/update rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            Freeradius::cadastraOuAtualizaRede($rede);
        }
    }

    /**
     * Handle the Rede "deleted" event.
     *
     * @param  \App\Models\Rede  $rede
     * @return void
     */
    public function deleted(Rede $rede)
    {
        // deleta rede no freeRadius
        if (config('copaco.freeradius_habilitar')) {
            // deleta equipamentos no freeRadius
            foreach ($rede->equipamentos as $equipamento) {
                if (config('copaco.freeradius_habilitar')) {
                    Freeradius::deletaEquipamento($equipamento);
                }
            }
            Freeradius::deletaRede($rede);
        }
    }

    /**
     * Handle the Rede "restored" event.
     *
     * @param  \App\Models\Rede  $rede
     * @return void
     */
    public function restored(Rede $rede)
    {
        //
    }

    /**
     * Handle the Rede "force deleted" event.
     *
     * @param  \App\Models\Rede  $rede
     * @return void
     */
    public function forceDeleted(Rede $rede)
    {
        //
    }
}
