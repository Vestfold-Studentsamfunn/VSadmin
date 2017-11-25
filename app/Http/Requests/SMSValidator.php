<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SMSValidator extends Request
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
            'message'          => 'required|Regex:/^[A-�a-�0-9\-\_!? \r\n,\'\"\/\@\.:;\(\)]+$/',
        ];
    }
}