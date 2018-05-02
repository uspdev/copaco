<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DomainAD implements Rule
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
        $domain_name_or_ip = $value;
        $regexp1 = "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i";
        $regexp2 = "/^.{1,253}$/";
        $regexp3 = "/^[^\.]{1,63}(\.[^\.]{1,63})*$/";
        $regexp4 = "/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/";
        $erro_dns = (preg_match($regexp1, $domain_name_or_ip) && preg_match($regexp2, $domain_name_or_ip) && preg_match($regexp3, $domain_name_or_ip));
        $erro_ip = preg_match($regexp4, $domain_name_or_ip);
        if(($erro_dns == true) OR ($erro_ip == true)){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Um Domain Active Directory válido é requerido.';
    }
}
