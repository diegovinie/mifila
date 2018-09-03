<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewTicket extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'cc' => 'required|numeric|max:10',
            'name' => 'required:min:3',
            'phone' => 'numeric|max:10',
            'email' => 'email|max:64',
            'priority' => 'boolean',
            'notificable' => 'boolean'
        ];
    }
}
