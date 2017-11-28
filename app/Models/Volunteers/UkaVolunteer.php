<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;

class UkaVolunteer extends Model
{
    protected $table = 'volunteerUKA';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'jobs',
    ];
}
