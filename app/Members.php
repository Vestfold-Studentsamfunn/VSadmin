<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'membersData';

    protected $fillable = [
        'name',
        'department',
        'birthdate',
        'vipGroup',
        'volunteer',
        'comment',
        'phone',
        'noPhone',
        'email',
        'noEmail',
        'semesters',
        'postalCode',
        'postalArea',
        'address',
        'cardNumber',
        'vipGroup',
        'u20',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'payedDate', 'birthDate', 'banned_from', 'banned_to'];

    /**
     * The jobs that belong to the member.
     */
    public function volunteerJobs() {
        return $this->belongsToMany('App\VolunteerJobs', 'volunteer_members', 'member_id', 'job_id')->withTimestamps();
    }
}
