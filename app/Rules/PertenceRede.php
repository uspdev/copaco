<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Utils\NetworkOps;
use Respect\Validation\Validator as v;

class PertenceRede implements Rule
{
    public $iprede;
    public $cidr;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($iprede, $cidr)
    {
        $this->iprede = $iprede;
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
        return NetworkOps::pertenceRede($value, $this->iprede, $this->cidr);
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
