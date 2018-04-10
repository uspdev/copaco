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
        if ($value == '') {
            return true;
        }

        $patrimonio = new dadosUsp;
        $xml = $patrimonio->fetchNumpat($value);
        if (strpos($xml,'The server encountered an unexpected condition') !== false) {
            return false;
        }
        // talvez os dados desse array em alguma coisa...
        $output = $patrimonio->xml2array($xml);
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Patrimonio nao valido';
    }
}
