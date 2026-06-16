<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Equipamento;
use App\Models\Rede;
use App\Models\User;

class EquipamentoCrudTest extends DuskTestCase
{
    public function test_equipamento_crud()
    {
        $this->browse(function (Browser $browser) {
            // Login obrigatório
            $browser->visit('/login')
                ->clickLink('Faça login usando senha única USP!');
            $browser->waitFor('#loginUsuario', 10)
                ->type('#loginUsuario', '1111')
                ->press('Login');
            // Início do teste crud
            //Criação da rede para o teste do equipamento
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

            $rede = Rede::latest()->first();

            //Create
            $browser->visit('/equipamentos/create')
                ->type('patrimonio', '200.106504')
                ->type('vencimento', '05/12/2032')
                ->type('macaddress', 'AF:60:38:94:D8:D9')
                ->type('local', 'Sala 02 STI')
                ->select('rede_id', $rede->id)
                ->type('descricao', 'Equipamento Teste')
                ->press('Enviar')
                ->pause(1000)
                ->assertSee('Equipamento Teste');

            $equipamento =  Equipamento::latest()->first();

            // Read
            $browser->visit("/equipamentos/{$equipamento->id}")
                ->visit("/equipamentos/{$equipamento->id}")
                ->pause(1000)
                ->assertSee('200.106504');

            // Update
            $browser->visit("/equipamentos/{$equipamento->id}/edit")
                ->assertSee('Editar Equipamento')
                ->type('patrimonio', '200.106505')
                ->press('Enviar')
                ->pause(1000)
                ->assertSee('200.106505');

            // Delete
            $browser->visit('/equipamentos')
                ->click("form[action$='/equipamentos/{$equipamento->id}'] button.delete-item")
                ->acceptDialog()  
                ->pause(1000)
                ->assertDontSee('200.106505');

            // Deletar a rede criada para o teste
            $browser->visit('/redes')
                ->click("form[action$='/redes/{$rede->id}'] button.delete-item")
                ->acceptDialog() 
                ->pause(1000)
                ->assertDontSee('Rede Teste Editada');
        });
    }
}