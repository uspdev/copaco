<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Rede;

class RedeCrudTest extends DuskTestCase
{
    public function test_rede_crud()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('login USP');
            $browser->waitFor('#loginUsuario')
                ->type('#callback', 'http://copaco/callback')
                ->type('#loginUsuario', '111111')
                ->press('Login')
                ->waitForText('você é super administrador', 15);
            // Início do teste crud
            //Create
            $browser->visit('/redes')
                ->waitForText('Nº de Redes Cadastradas:', 15)
                ->assertSee('Nº de Redes Cadastradas:')
                ->visit('/redes/create')
                ->waitForText('Cadastrar Rede', 15)
                ->assertSee('Cadastrar Rede')
                ->type('nome', 'Rede Teste')
                ->type('iprede', '141.232.67.0')
                ->type('cidr', '24')
                ->type('gateway', '141.232.67.1')
                ->type('vlan', '10')
                ->type('netbios', '10.3.3.2')
                ->type('ntp', '172.16.0.28')
                ->type('dns', '143.107.253.3')
                ->type('ad_domain', 'dominiodusk.usp.br')
                ->select('shared_network', 'default')
                ->check('active_dhcp')
                ->press('Enviar Dados')
                ->waitForText('Rede Teste', 15)
                ->assertSee('Rede Teste');

            $rede =  Rede::latest()->first();

            // Read
            $browser->visit("/redes/{$rede->id}")
                ->waitForText('Rede Teste', 15)
                ->assertSee('Rede Teste');

            // Update
            $browser->visit("/redes/{$rede->id}/edit")
                ->waitForText('Editar Rede', 15)
                ->assertSee('Editar Rede')
                ->type('nome', 'Rede Teste Editada')
                ->press('Enviar Dados')
                ->waitForText('Rede Teste Editada', 15)
                ->assertSee('Rede Teste Editada');

            // Gerar Keadhcp
            $browser->visit("/config")
                ->press('Gerar configuração Kea (JSON) - Redes segmentadas')
                ->waitForText('141.232.67.1', 15)
                ->assertSee('141.232.67.1');

            // Delete
            $browser->visit('/redes')
                ->click("form[action$='/redes/{$rede->id}'] button.delete-item")
                ->acceptDialog()
                ->waitUntilMissingText('Rede Teste Editada', 15)
                ->assertDontSee('Rede Teste Editada');
        });
    }
}
