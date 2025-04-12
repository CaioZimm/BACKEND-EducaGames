<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'role',
        'password',
        'foundation_id',
        'avatar_id'
    ];

    public function foundation(){
        return $this->belongsTo(Foundation::class); // UM usuário pertence à UMA Instituição;
    }
    public function avatar(){
        return $this->belongsTo(Avatar::class); // UM usuário pode ter UM avatar;
    }
    public function answer(){
        return $this->hasMany(Answer::class); // UM usuario pode ter VÁRIAS respostas;
    }
    public function result(){
        return $this->hasMany(Result::class); // UM usuario pode ter VÁRIOS resultados de jogos;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
