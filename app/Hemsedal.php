<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hemsedal extends Model
{
    protected $table = 'hemsedalData';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'depPayed_at', 'allPayed_at'];
}
