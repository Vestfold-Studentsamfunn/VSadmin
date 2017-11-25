<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateMemberProfileRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'address'       => 'required',
            'postalCode'    => 'required',
            'postalArea'    => 'required',
            'phone'         => 'required|numeric|min:8',
            'email'         => 'required|email',
            'birthDate'     => 'required|date_format:d.m.Y',
            'department'    => 'required',
            'semesters'     => 'required|numeric',
            'picture'       => 'image',
        ];
    }
}
