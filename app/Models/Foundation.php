<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foundation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'deleted_at'
    ];

    public function user(){
        return $this->hasMany(User::class); // UMA instituição pode ter VÁRIOS usuários;
    }
    public function game(){
        return $this->hasMany(Game::class); // UMA instituição pode ter VÁRIOS jogos;
    }
}
