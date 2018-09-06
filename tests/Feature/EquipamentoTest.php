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

    public function testCrudEquipamento()
    {
        // Verifica se o cadastro de equipamentos é restrito
        $response = $this->get('/equipamentos/create');
        $response->assertStatus(302);

        // Novo usuário para os testes, pois as rotas são protegidas
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', $user->toArray());
        $this->actingAs($user);

        // Verifica se form existe e é acessível
        $response = $this->get('/equipamentos/create');
        $response->assertStatus(200);

        // Cadastrar novo equipamento via requisição POST http
        $equipamento = factory(Equipamento::class)->make();
        
        // no form, a data deve ser no padrãp dd/mm/yyyy
        $equipamento->vencimento = implode('/',array_reverse(explode('-',$equipamento->vencimento)));

        // cadastro do equipamento via post
        $response = $this->post('equipamentos', $equipamento->toArray());

        // Pegar o objeto com id do equipamento cadastrado
        $equipamento = Equipamento::where('macaddress',$equipamento->macaddress)->first();

        // verifica se o novo equipamento aparece na index
        $response = $this->get('/equipamentos');
        $response->assertStatus(200);
        $response->assertSeeText($equipamento->macaddress);

        // verifica se o novo equipamento tem um página de show
        $response = $this->get("/equipamentos/{$equipamento->id}");
        $response->assertStatus(200);
        $response->assertSeeText($equipamento->macaddress);

        // Verifica se a rota de edição existe
        $response = $this->get("/equipamentos/{$equipamento->id}/edit");
        $response->assertStatus(200);

        // edita data de venciemnto do equipamento
        $equipamento->vencimento = '01/01/219' . rand(1,9);     
        $response = $this->patch("/equipamentos/{$equipamento->id}", $equipamento->toArray());

        // verifica se o equipamento editado, alterou mesmo em show
        $response = $this->get("/equipamentos/{$equipamento->id}");
        $response->assertStatus(200);
        $response->assertSeeText($equipamento->vencimento);

        // verifica delete do equipamento via post request
        $response = $this->delete("/equipamentos/{$equipamento->id}");

        // verifica se na index essa equipamento não aparece mais
        $response = $this->get("/equipamentos");
        $response->assertDontSeeText("$equipamento->macaddress"); 
        
        // Observação: no make do factory, usuário e rede são criado. Assim esse
        //  teste deixa o banco "sujo"
   
    }
}
