<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use App\Models\Rede;
use Tests\DuskTestCase;

class KeaDhcpTest extends DuskTestCase
{
    public function test_kea_dhcp(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('login USP')
                ->waitFor('#loginUsuario')
                ->type('#callback', 'http://copaco/callback')
                ->type('#loginUsuario', '111111')
                ->press('Login')
                ->waitForText('você é super administrador', 15);

            $browser->visit('/redes')
                ->waitForText('Nº de Redes Cadastradas:', 15)
                ->visit('/redes/create')
                ->waitForText('Cadastrar Rede', 15)
                ->type('nome', 'Rede Teste KEA')
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
                ->waitForText('Rede Teste KEA', 15)
                ->assertSee('Rede Teste KEA');

            $rede = Rede::latest()->first();

            $browser->visit('/config')
                ->press('Gerar configuração Kea (JSON) - Redes segmentadas')
                ->waitForText('141.232.67.1', 15)
                ->assertSee('141.232.67.1');

            $browser->visit('/redes')
                ->click("form[action$='/redes/{$rede->id}'] button.delete-item")
                ->acceptDialog()
                ->waitUntilMissingText('Rede Teste KEA', 15)
                ->assertDontSee('Rede Teste KEA');
        });
    }
}
