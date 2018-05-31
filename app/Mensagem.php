<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;
class Mensagem extends Model
{
    protected $fillable = [
        'mensagem', 'contato_id',
    ];

    private $errors;

    private $rules = array(
        'contato_id' => 'required',
        'mensagem' => 'required',
    );

    private $message = array(
        'contato_id.required' => 'Id contato obrigatorio',
        'mensagem.required' => 'Mensagem obrigatoria',
    );

    public function contato()
    {
        return $this->belongsTo('App\Contato', 'contato_id', 'id');
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
