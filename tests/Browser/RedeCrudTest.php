<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Rede;
use App\Models\User;

class RedeCrudTest extends DuskTestCase
{
    public function test_rede_crud()
    {
        $this->browse(function (Browser $browser) {
            // Login obrigatório
            $browser->visit('/login')
                ->clickLink('Faça login usando senha única USP!');
            $browser->waitFor('#loginUsuario', 10)
                ->type('#loginUsuario', '1111')
                ->press('Login');
            // Início do teste crud
            //Create
            $browser->visit('/redes')
                ->assertSee('Adicionar Rede')
                ->visit('/redes/create')
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
                ->pause(1000)
                ->assertSee('Rede Teste');

            $rede =  Rede::latest()->first();

            // Read
            $browser->visit("/redes/{$rede->id}")
                ->pause(1000)
                ->assertSee('Rede Teste');

            // Update
            $browser->visit("/redes/{$rede->id}/edit")
                ->assertSee('Editar Rede')
                ->type('nome', 'Rede Teste Editada')
                ->press('Enviar Dados')
                ->pause(1000)
                ->assertSee('Rede Teste Editada');

            // Gerar Keadhcp
            $browser->visit("/config")
                ->press('Gerar configuração Kea (JSON) - Redes segmentadas')
                ->pause(2000)
                ->assertSee('141.232.67.1');

            // Delete
            $browser->visit('/redes')
                ->click("form[action$='/redes/{$rede->id}'] button.delete-item")
                ->acceptDialog() 
                ->pause(1000)
                ->assertDontSee('Rede Teste Editada');
        });
    }
}