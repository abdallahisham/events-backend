<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hash;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')],
            'mobile_number' => ['required', Rule::unique('users')],
            'password' => ['required'],
            'desc' => ['required']
        ];
    }
    
    public function prepared()
    {
        return [
            'name' => request('name'),
            'email' => request('email'),
            'mobile_number' => request('mobile_number'),
            'password' => Hash::make(request('password')),
            'desc' => request('desc')
        ];
    }
}
