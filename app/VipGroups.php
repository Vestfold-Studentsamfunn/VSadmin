<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VipGroups extends Model
{
    protected $table = 'vipGroups';

    protected $fillable = [
        'name',
        'description'
    ];}
