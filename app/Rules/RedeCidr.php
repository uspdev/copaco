<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rede;

class RedeCidr implements Rule
{
    private $iprede;
    private $cidr;
    private $except;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($iprede, $cidr, $except=0)
    {
        //
        $this->iprede = $iprede;
        $this->cidr = $cidr;
        $this->except = $except;
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
        //
        $redes = Rede::all()->except($this->except);
        foreach ($redes as $rede) {
            if ($this->iprede == $rede->iprede && $this->cidr == $rede->cidr) {
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
        return "A rede $this->iprede/$this->cidr já existe. Por favor altere!";
    }
}
