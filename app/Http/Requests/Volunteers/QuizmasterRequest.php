<?php

namespace App\Http\Requests\Volunteers;

use App\Http\Requests\Request;

class QuizmasterRequest extends Request
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
            'name_q1'   => 'required|string',
            'phone_q1'  => 'required|numeric',
            'email_q1'  => 'required|email',
            'name_q2'   => 'string',
            'phone_q2'  => 'numeric',
            'email_q2'  => 'email',
        ];
    }
}