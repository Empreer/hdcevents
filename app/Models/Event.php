<?php

namespace App\Models;   //MODEL É CRIADO VIA O COMANDO ARTISAN CREATE MODEL

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model    // O QUE CONECTA É A CLASS EVENT QUE É O NOME DA TABELA NO SINGULAR.
{
    use HasFactory;

    protected $casts = [
        'items' => 'array'   // Tratamento do Itens que vem como array formato json
    ];

    protected $dates = ['date'];

   
    protected $guarded = []; //Método para liberar o Post no banco.


    public function user() {
        return $this->belongsTo('App\Models\User'); //belgons to - Evento pertence a um usuário
    }

    public function users() {
        return $this->belongsToMany('App\Models\User'); //belgons to many faz ligacao de varios para varios
    }

}
