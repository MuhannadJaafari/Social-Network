<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use TheSeer\Tokenizer\Exception;

class UserAccountCreatingRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required',
            'birth_date'=>'required',
            'username'=>'required|unique:usernames,name',
        ];
    }

    public function messages()
    {
        return [
            'email'=>'The email is already taken'
        ];
    }
}
