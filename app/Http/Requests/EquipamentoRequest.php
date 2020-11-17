<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Rede;

class EquipamentoRequest extends FormRequest
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
            'patrimonio' => ['nullable'],
            'macaddress' => [
                'required',
            ],
            'descricao' => ['nullable'],
            'local' => '',
            'vencimento' => 'nullable|date_format:"d/m/Y"|after:today',
            'rede_id' => ['nullable', Rule::in(Rede::allowed()->get()->sortBy('nome')->pluck('id'))],
            'fixarip' => 'required',
            'ip' => 'nullable|ip|required_if:fixarip,1',
        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT'){
            array_push($rules['macaddress'], 'unique:equipamentos,macaddress,'.$this->equipamento->id);
        }
        else{
            array_push($rules['macaddress'], 'unique:equipamentos');
        }
        return $rules;
    }

}
