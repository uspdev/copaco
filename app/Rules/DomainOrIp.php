<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Respect\Validation\Validator as v;

class DomainOrIp implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $field;
    public function __construct($field = null)
    {
        $this->field = $field;
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
        $values = explode(',',$value);
        foreach($values as $v)
        if ( !(v::domain()->validate(trim($v)) or v::ip()->validate(trim($v)) or empty($v) )) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->field . ': Domínio(s) ou IP(s) válido(s) é(são) requerido(s)';
    }
}
