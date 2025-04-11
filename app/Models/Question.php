<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'type',
        'score',
        'game_id',
        'deleted_at'
    ];

    public function game(){
        return $this->belongsTo(Game::class); // UMA pergunta pertence à UM jogo;
    }
    public function answer(){
        return $this->hasMany(Answer::class); // UMA pergunta pode ter VÁRIAS respostas;
    }
    public function alternative(){
        return $this->hasMany(Alternative::class); // UMA pergunta pode ter VÁRIAS alternativas;
    }
}