<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;

class Quizmaster extends Model
{
    protected $table = 'volunteerQuiz';

    protected $fillable = [
        'name_q1',
        'phone_q1',
        'email_q1',
        'name_q2',
        'phone_q2',
        'email_q2',
    ];

    //protected $dateFormat = 'U';
}
