<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Respect\Validation\Validator as v;

class MultiplesIP implements Rule
{
    private $field;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        foreach($values as $v) {
            if ( !(v::ip()->validate(trim($v)) or empty($v) )) {
                return false;
            }
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
        return $this->field . ': IP(s) válido(s) é(são) requerido(s)';
    }
}
