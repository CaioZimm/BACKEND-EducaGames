<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'game';

    protected $fillable = [
        'title',
        'description',
        'mode',
        'closed_time',
        'password',
        'max_score',
        'foundation_id',
        'deleted_at'
    ];

    public function foundation(){
        return $this->belongsTo(Foundation::class); // UM jogo pertence à UMA Instituição;
    }
    public function question(){
        return $this->hasMany(Question::class); // UM jogo pode ter VÁRIAS perguntas;
    }
    public function result(){
        return $this->hasMany(Result::class); // UM jogo pode ter VÁRIOS resultados de jogadores;
    }
}
