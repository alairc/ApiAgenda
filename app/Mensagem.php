<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $fillable = [
        'mensagem', 'contato_id',
    ];

    public function contato()
    {
        return $this->belongsTo('App\Contato', 'contato_id', 'id');
    }

}
