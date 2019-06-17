<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CodigoAcesso implements Rule
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
        if(config('copaco.somente_senhaunica')) {
            return false;
        }

        if( $value != config('copaco.codigo_acesso') ) {
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
        return 'Código de acesso inválido ou o cadastro de usuário local não está habilitado';
    }
}
