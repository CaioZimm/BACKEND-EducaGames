<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'is_correct',
        'alternative_id',
        'user_id',
        'question_id'
    ];

    public function alternative(){
        return $this->belongsTo(Alternative::class); // UMA resposta pode ter VÁRIAS alternativas;
    }
    public function user(){
        return $this->hasMany(User::class); // UMA resposta pode pertencer a VÁRIOS usuários;
    }
    public function question(){
        return $this->belongsTo(Question::class); // UMA resposta pertence à UMA pergunta;
    }
}
