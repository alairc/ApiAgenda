<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class Contato extends Model
{
    protected $fillable = [
        'nome', 'sobrenome','email','telefone',
    ];

    private $errors;

    private $rules = array(
        'nome' => 'required|min:3|max:30',
        'sobrenome' => 'required|min:2|max:100',
        'email' => 'required|min:5|max:100|unique:contatos,email',
        'telefone' => 'required',
    );

    private $message = array(
        'nome.required' => 'Nome obrigatorio',
        'sobrenome.required' => 'Sobrenome obrigatorio',
        'email.required' => 'E-mail obrigatorio',
        'telefone.required' => 'Telefone obrigatorio',
        'email.min' => 'Minimo 5 caracteres',
        'email.max' => 'Maximo 100 caracteres',
        'email.unique' => 'E-mail ja cadastrado',
        'nome.min' => 'Minimo 3 caracteres',
        'nome.max' => 'Maximo 100 caracteres',
        'sobrenome.min' => 'Minimo 2 caracteres',
        'sobrenome.max' => 'Maximo 100 caracteres',

    );

    public function mensagens()
    {
        return $this->hasMany('App\Mensagem', 'contato_id', 'id');
    }

    public function validate($data)
    {
        $validade = Validator::make($data, $this->rules, $this->message);
        if ($validade->fails())
        {
            $this->errors = $validade->errors();
            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}
