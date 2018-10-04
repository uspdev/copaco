<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Respect\Validation\Validator as v;

class Domain implements Rule
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
        if ( !(v::domain()->validate(trim($value)) or empty($value) )) {
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
        return $this->field . ': Um domínio válido é requerido';
    }
}
