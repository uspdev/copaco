<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Uspdev\dadosUsp;

class Patrimonio implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('/\d{3}\.\d{6}/', $value) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Patrimônio inválido. Exemplo: 008.048742';
    }
}
