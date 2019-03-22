<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Utils\NetworkOps;
use Respect\Validation\Validator as v;

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
        if ( !v::ip()->validate($this->iprede) or !v::ip()->validate($this->gateway) or !v::intVal()->validate($this->cidr)) {
            return false;
        }

        if (NetworkOps::pertenceRede($this->gateway, $this->iprede, $this->cidr)) {
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
        return 'O :attribute não está no range da rede';
    }
}
