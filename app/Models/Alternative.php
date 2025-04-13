<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;
    protected $table = 'alternative';

    protected $fillable = [
        'description',
        'is_correct',
        'question_id'
    ];

    public function question(){
        return $this->belongsTo(Question::class); // UMA alternativa pertence à UMA pergunta;
    }
    public function answer(){
        return $this->hasMany(Answer::class); // UMA alternativa pode ter VÁRIAS respostas;
    }
}
