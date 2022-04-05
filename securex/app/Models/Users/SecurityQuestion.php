<?php

namespace App\Models\Users;

use App\Http\Traits\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    use EncryptAttributes;

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['question_1', 'answer_1', 'question_2', 'answer_2'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question_1', 'answer_1', 'question_2', 'answer_2'];

    /**
     * Relation between SecurityQuestions and a User.
     * A security question row belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
