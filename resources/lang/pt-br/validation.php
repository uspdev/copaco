<?php

return [

    'accepted'             => ':attribute deve ser aceito.',
    'active_url'           => ':attribute não é uma URL válida.',
    'after'                => ':attribute deve ser uma data posterior a :date.',
    'after_or_equal'       => ':attribute deve ser uma data igual ou posterior a :date.',
    'alpha'                => ':attribute deve conter somente letras.',
    'alpha_dash'           => ':attribute deve conter apenas letras, números e traços.',
    'alpha_num'            => ':attribute deve conter apenas letras e números.',
    'array'                => ':attribute deve ser um array.',
    'before'               => ':attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => ':attribute deve ser uma data igual ou anterior a :date.',
    'between'              => [
        'numeric' => ':attribute deve ter um valor entre :min e :max.',
        'file'    => ':attribute deve ter um valor entre :min e :max kilobytes.',
        'string'  => ':attribute deve ter um valor entre :min e :max caracteres.',
        'array'   => ':attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => ':attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'Erro na confirmação - :attribute.',
    'date'                 => ':attribute não é uma data válida.',
    'date_format'          => ':attribute não está no formato :format.',
    'different'            => ':attribute e :other devem ser diferentes.',
    'digits'               => ':attribute deve ter :digits dígitos.',
    'digits_between'       => ':attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'A imagem :attribute tem dimensões inválidas.',
    'distinct'             => ':attribute tem um valor duplicado.',
    'email'                => ':attribute deve ser um e-mail válido.',
    'exists'               => 'O atributo selecionado - :attribute - é inválido.',
    'file'                 => ':attribute deve ser um arquivo.',
    'filled'               => ':attribute deve ter um valor.',
    'image'                => ':attribute deve ser uma imagem.',
    'in'                   => 'O atributo selecionado - :attribute - é inválido.',
    'in_array'             => ':attribute não existe em :other.',
    'integer'              => ':attribute deve ser um número inteiro.',
    'ip'                   => ':attribute deve ser um endereço de IP válido.',
    'ipv4'                 => ':attribute deve ser um IPv4 válido.',
    'ipv6'                 => ':attribute deve ser um IPv6 válido.',
    'json'                 => ':attribute deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => ':attribute não deve ser maior que :max.',
        'file'    => ':attribute não deve ser maior que :max kilobytes.',
        'string'  => ':attribute não deve ser maior que :max caracteres.',
        'array'   => ':attribute não deve ter mais que :max itens.',
    ],
    'mimes'                => ':attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => ':attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute deve ser no mínimo :min.',
        'file'    => ':attribute deve ser no mínimo :min kilobytes.',
        'string'  => ':attribute deve ser no mínimo :min caracteres.',
        'array'   => ':attribute deve ter no mínimo :min itens.',
    ],
    'not_in'               => ':attribute nválido.',
    'numeric'              => ':attribute deve ser um número.',
    'present'              => ':attribute deve estar presente.',
    'regex'                => ':attribute tem formato inválido.',
    'required'             => ':attribute é obrigatório.',
    'required_if'          => ':attribute é necessário quando :other é :value.',
    'required_unless'      => ':attribute é necessário a menos que :other enteja entre :values.',
    'required_with'        => ':attribute é necessário quando :values está presente.',
    'required_with_all'    => ':attribute é necessário quando :values está presente.',
    'required_without'     => ':attribute é necessário quando :values não está presente.',
    'required_without_all' => ':attribute é necessário quando nenhum de :values está presente.',
    'same'                 => ':attribute e :other devem combinar.',
    'size'                 => [
        'numeric' => ':attribute deve ser do tamanho :size.',
        'file'    => ':attribute deve ter :size kilobytes.',
        'string'  => ':attribute deve ter :size caracteres.',
        'array'   => ':attribute deve conter :size itens.',
    ],
    'string'               => ':attribute deve ser uma string.',
    'timezone'             => ':attribute deve ser uma timezone.',
    'unique'               => ':attribute já foi usado.',
    'uploaded'             => ':attribute - falha no upload.',
    'url'                  => ':attribute tem um formato inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

