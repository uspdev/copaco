<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rede;

class RedeCidr implements Rule
{
    private $cidr;
    private $rede_id;

    /**
     * Create a new rule instance.
     *
     * @int rede_id - Id a ser ignorada ao executar RedeController@update()
     * @return void
     */
    public function __construct($cidr, $rede_id = 0)
    {
        $this->rede_id = $rede_id;
        $this->cidr = $cidr;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($ip_rede, $value)
    {
        $redes = Rede::where('iprede', $value)
                    ->get()
                    ->except($this->rede_id);
        # Se NÃO contiver o cidr, retorna true
        return !$redes->contains('cidr', $this->cidr);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "A rede $this->iprede/$this->cidr já existe. Por favor altere!";
    }
}
