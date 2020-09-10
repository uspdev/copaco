<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MultiplesIP;
use App\Rules\Domain;
use App\Rules\PertenceRede;
use App\Utils\Freeradius;
use App\Rules\RedeCidr;
class RedeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nome'      => 'required',
            'shared_network'      => 'required',
            'iprede'    => ['ip','required','different:gateway', new RedeCidr($this->cidr,$this->iprede)],
            'cidr'      => 'required|numeric|min:8|max:30',
            'vlan'      => 'numeric',
            'gateway'   => ['ip','required', new PertenceRede($this->gateway, $this->iprede, $this->cidr)],
            'dns'       => [new MultiplesIP('DNS')],
            'netbios'   => [new MultiplesIP('NetBIOS')],
            'ad_domain' => [new Domain('Active Directory Domain')],
            'ntp'       => [new MultiplesIP('NTP')],
        ];
        //if ($this->method() != 'PATCH' || $this->method() != 'PUT'){
            //array_push($rules['iprede'], ['ip','required','different:gateway', new RedeCidr($this->cidr,$this->iprede)]);
        //}
        return $rules;
    }
}
