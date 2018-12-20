<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|unique:users',
            'password' => 'required'
        ];
    }
    
    public function prepared()
    {
        return [
            'name' => $this->request->get('name'),
            'email' => $this->request->get('email'),
            'mobile_number' => $this->request->get('mobile_number'),
            'password' => Hash::make($this->request->get('password')),
        ];
    }
}
