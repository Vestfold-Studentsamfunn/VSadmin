<?php

namespace App\Http\Requests\Volunteers;

use App\Http\Requests\Request;

class UkaVolunteerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only allow logged in users
        return \Auth::check();
    }

    /**
     * Get the validation rules that applies to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'jobs'  => 'required|string'
        ];
    }
}