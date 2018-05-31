<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'nome', 'sobrenome','email','telefone',
    ];

    public function mensagens()
    {
        return $this->hasMany('App\Mensagem', 'contato_id', 'id');
    }
}
