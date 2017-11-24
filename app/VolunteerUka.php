<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolunteerUka extends Model
{
    protected $table = 'volunteerUKA';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'jobs',
    ];
}
