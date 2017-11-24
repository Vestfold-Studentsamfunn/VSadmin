<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function authorize()
    {
        // Only allow logged in users
        return \Auth::check();
        // Allows all users in
        // return true;
    }
}
