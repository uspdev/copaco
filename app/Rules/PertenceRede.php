<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Utils\NetworkOps;

class PertenceRede implements Rule
{
    public $iprede;
    public $gateway;
    public $cidr;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($iprede, $gateway, $cidr)
    {
        $this->iprede = $iprede;
        $this->gateway = $gateway;
        $this->cidr = $cidr;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ops = new NetworkOps;

        if ($ops->pertenceRede($this->gateway, $this->iprede, $this->cidr)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O IP de :attribute não está no intervalo da rede';
    }
}
