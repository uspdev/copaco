<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavegacaoTest extends DuskTestCase
{
    public function test_navegacao()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('login USP');
            $browser->waitFor('#loginUsuario')
                ->type('#callback', 'http://copaco/callback')
                ->type('#loginUsuario', '111111')
                ->press('Login');

            $browser->visit('/')
                ->assertSee('você é super administrador');

            $browser->visit('/equipamentos')
                ->Pause(3000)
                ->assertSee('Equipamentos')
                ->visit('/redes/create')
                ->Pause(3000)
                ->assertSee('Cadastrar Rede')
                ->visit('/redes')
                ->Pause(3000)
                ->assertSee('Adicionar Rede')
                ->visit('/redes/migrate')
                ->Pause(3000)                
                ->assertSee('Migração de equipamentos entre redes')
                ->visit('/config')
                ->Pause(3000)                
                ->assertSee('Configurações');
        });
    }
}
