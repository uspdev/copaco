<?php

namespace Database\Factories;

use App\Models\Rede;
use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Utils\NetworkOps;

class EquipamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
         //Busca aleatoriamente um grupo
        $role_user = DB::table('role_user')->inRandomOrder()->first();
        
        //Baseado no grupo ao que usuário pertence, busca-se as redes que estão disponíveis para esse grupo
        $role_rede = DB::table('role_rede')->where('role_id',$role_user->role_id)->inRandomOrder()->first();

        //Aqui retorna-se um collection da rede selecionada aleatoriamente para configuração do equipamento
        $rede = Rede::find($role_rede->rede_id);
            
        // Não começa em zero para excluir gateway
        $ip_selecionado = NetworkOps::getRandomIP($rede->iprede, $rede->cidr);

        // fixar IPs
        $fixarip = $this->faker->boolean();
        if(!$fixarip){
            $ip_selecionado = null;
            $rede->id = null;
        }
        return [
            'naopatrimoniado' => 0,
            'patrimonio' => null,
            'descricaosempatrimonio' => $this->faker->paragraph(1),
            'macaddress' => $this->faker->unique()->macAddress,
            'local' => $this->faker->word,
            'vencimento' => date("Y-m-d", strtotime("+".rand(30, 360)."days")),
            'fixarip' => $fixarip,
            'ip' => $ip_selecionado,
            'rede_id' => $rede->id,
            'user_id' => $role_user->user_id,
        ];
    }
}
