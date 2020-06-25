<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rede;
use App\User;
use App\Equipamento;

class EquipamentoTest extends TestCase
{
    public function testModelEquipamento()
    {
        // Cadastra novo usuário e verifica se o mesmo está no banco de dados
        $equipamento = factory(Equipamento::class)->create();
        $this->assertDatabaseHas('equipamentos', $equipamento->toArray());

        // Deleta usuário do banco
        $equipamento->delete();
    }

}
