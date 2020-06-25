<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rede;
use App\User;

class RedeTest extends TestCase
{
    /**
     * testa o model
     *
     * @return void
     */
    public function testModelRede()
    {
        // Cadastra novo usuário e verifica se o mesmo está no banco de dados
        $rede = factory(Rede::class)->create();
        $this->assertDatabaseHas('redes', $rede->toArray());

        // Deleta usuário do banco
        $rede->delete();
    }

}
