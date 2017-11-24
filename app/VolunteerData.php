<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolunteerData extends Model
{
    protected $table = 'volunteerData';

    protected $fillable = [
        'name',
        'phone',
        'email',
    ];


    /**
     * The jobs that belong to the member.
     */
    public function volunteerJobs() {
        return $this->belongsToMany('App\VolunteerJobs', 'volunteer_members', 'volunteer_id', 'job_id')->withTimestamps();
    }

}
