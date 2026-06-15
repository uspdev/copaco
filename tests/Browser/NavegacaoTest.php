<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavegacaoTest extends DuskTestCase
{
    public function test_navegacao()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->clickLink('Faça login usando senha única USP!');
            $browser->waitFor('#loginUsuario', 10)
                ->type('#loginUsuario', '1111')
                ->press('Login');

            $browser->visit('/')
                ->assertSee('você é super administrador');

            $browser->visit('/equipamentos')
                ->assertSee('Equipamentos')
                ->visit('/redes/create')
                ->assertSee('Cadastrar Rede')
                ->visit('/redes')
                ->assertSee('Adicionar Rede')
                ->visit('/redes/migrate')
                ->assertSee('Migração de equipamentos entre redes')
                ->visit('/config')
                ->assertSee('Configurações')
                ->visit('/roles')
                ->assertSee('Adicionar Grupo')
                ->visit('/users')
                ->assertSee('Nome de Usuário');
        });
    }
}