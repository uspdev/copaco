<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * testa o model
     *
     * @return void
     */
    public function testModelUser()
    {
        // Cadastra novo usuário e verifica se o mesmo está no banco de dados
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', $user->toArray());

        // Deleta usuário do banco
        $user->delete();
    }
}
