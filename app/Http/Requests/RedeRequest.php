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
            'nome'              => ['required'],
            'shared_network'    => 'required',
            'iprede'            => ['ip','required','different:gateway'],
            'cidr'              => 'required|numeric|min:8|max:30',
            'vlan'              => 'numeric',
            'gateway'           => ['ip','required', new PertenceRede($this->gateway, $this->iprede, $this->cidr)],
            'dns'               => [new MultiplesIP('DNS')],
            'netbios'           => [new MultiplesIP('NetBIOS')],
            'ad_domain'         => [new Domain('Active Directory Domain')],
            'ntp'               => [new MultiplesIP('NTP')],
            'active_dhcp'       => 'nullable|boolean',
            'active_freeradius' => 'nullable|boolean',
        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT'){
            array_push($rules['nome'], 'unique:redes,nome,' .$this->rede->id);
            array_push($rules['iprede'], new RedeCidr($this->cidr,$this->iprede,$this->rede->id));
        } else {
            array_push($rules['nome'], 'unique:redes');
            array_push($rules['iprede'], new RedeCidr($this->cidr,$this->iprede));
        }
        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active_dhcp' => isset($this->active_dhcp) ? $this->active_dhcp:0,
            'active_freeradius' => isset($this->active_freeradius) ? $this->active_freeradius:0,
        ]);
    }
}
