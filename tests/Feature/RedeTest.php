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

    public function testCrudRede()
    {
        // Verifica se o cadastro de rede é restrito
        $response = $this->get('/redes/create');
        $response->assertStatus(302);

        // Novo usuário para os testes, pois as rotas são protegidas
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', $user->toArray());
        $this->actingAs($user);

        // Verifica se form existe e é acessível
        $response = $this->get('/redes/create');
        $response->assertStatus(200);

        // Cadastrar nova rede via requisição POST http
        $rede = factory(Rede::class)->make();
        $response = $this->post('redes', $rede->toArray());

        // verifica se nova rede aparece na index de redes
        $response = $this->get('/redes');
        $response->assertStatus(200);
        $response->assertSeeText($rede->nome);

        // Consulta para pegar rede criada, em especial o id
        $rede = Rede::where('nome',$rede->nome)
                   ->where('iprede',$rede->iprede)
                    ->where('gateway',$rede->gateway)
                    ->where('dns',$rede->dns)
                    ->where('ntp',$rede->ntp)
                    ->where('netbios',$rede->netbios)
                    ->where('cidr',$rede->cidr)
                    ->where('vlan',$rede->vlan)
                    ->where('ad_domain',$rede->ad_domain)
                    ->where('cidr',$rede->cidr)
                    ->where('last_modify_by',$user->id)
                    ->where('user_id',$user->id)->first();

        // verifica se a nova rede tem um página de show
        $response = $this->get("/redes/{$rede->id}");
        $response->assertStatus(200);
        $response->assertSeeText($rede->nome);

        // Verifica se a rota de edição existe
        $response = $this->get("/redes/{$rede->id}/edit");
        $response->assertStatus(200);

        // edita rede criada
        $rede->titulo = 'new network';     
        $response = $this->patch("/redes/{$rede->id}", $rede->toArray());
        $response->assertRedirect("/redes/{$rede->id}");

        // verifica se a rede editada tem um página de show
        $response = $this->get("/redes/{$rede->id}");
        $response->assertStatus(200);
        $response->assertSeeText($rede->nome);

        // verifica delete da rede via post request
        $response = $this->delete("/redes/{$rede->id}");

        // verifica se na index um link dessa rede não aparece mais
        $response = $this->get("/redes");
        $response->assertDontSee("redes/$rede->id");

        // Apaga usuário criado para testes
        $user->delete();
        
    }

}
