<?php

namespace Database\Factories;

use App\Models\Rede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Utils\NetworkOps;

class RedeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rede::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Seleciona o gateway como o primeiro ip da rede
        $redes = ['10.0.0.0', '20.0.0.0', '30.0.0.0', '40.0.0.0', '50.0.0.0', '60.168.0.0', '70.0.0.0', '80.0.0.0', '90.0.0.0', '100.0.0.0', '110.0.0.0'];
        $iprede = $redes[array_rand($redes)];
        $cidr = $this->faker->numberBetween(21, 30);

        // usuários
        $user_modify = User::get("id")->toArray();
        //$user_modify = ['1','2','3','4','5'];
        return [
            'nome'      => $this->faker->unique()->domainWord() . " network",
            'iprede'    => $iprede,
            'gateway'   => NetworkOps::findFirstIP($iprede, $cidr),
            'dns'       => NetworkOps::getRandomIP($iprede, $cidr),
            'ntp'       => NetworkOps::getRandomIP($iprede, $cidr),
            'netbios'   => NetworkOps::getRandomIP($iprede, $cidr),
            'cidr'      => $cidr,
            'vlan'      => $this->faker->unique()->numberBetween(10, 100),
            'ad_domain' => $this->faker->domainName,
            'user_id'   => $user_modify[array_rand($user_modify)]['id'],
            'shared_network' => 'default',
        ];
    }
}
