<?php

namespace App\Rules;

use laravellegends\PtBrValidator\Rules\Cnpj;
use laravellegends\PtBrValidator\Rules\Cpf;
use Illuminate\Contracts\Validation\Rule;

class Documento implements Rule
{
    public function passes($attribute, $value){
        if(strlen($value) == 11){
            $cpf = new Cpf();
            return $cpf->passes($attribute, $value);
        }

        $cnpj = new Cnpj();
        return $cnpj->passes($attribute, $value);
    }

    public function message(){
        return 'O :attribute deve ser um CPF ou CNPJ válido.';
    }
}
