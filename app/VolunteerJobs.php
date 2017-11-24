<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolunteerJobs extends Model
{
    protected $table = 'volunteerJobs';

    protected $fillable = [
        'name',
        'description',
    ];


    /**
     * The members that belong to the job.
     */
    public function members() {
        return $this->belongsToMany('App\VolunteerData', 'volunteer_members', 'job_id', 'volunteer_id')->withTimestamps();
    }

}
