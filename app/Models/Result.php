<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $table = 'result';

    protected $fillable = [
        'your_score',
        'game_id',
        'user_id'
    ];

    public function game(){
        return $this->belongsToMany(Game::class); // VÁRIOS resultados podem pertencer a VÁRIOS jogos;
    }
    public function user(){
        return $this->belongsToMany(User::class); // VÁRIOS usuários podem ter VÁRIOS resultados;
    }
}
