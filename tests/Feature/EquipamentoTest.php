<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Rede;
use App\Models\User;
use App\Models\Equipamento;

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
