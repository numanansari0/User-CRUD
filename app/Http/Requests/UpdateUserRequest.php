<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => ['nullable', 'string', 'min:6'], // Base rules
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $password = $this->input('password');

            if ($password) {
                if (!preg_match('/[A-Z]/', $password)) {
                    $validator->errors()->add('password', 'Password must contain at least one uppercase letter.');
                }

                if (!preg_match('/\d/', $password)) {
                    $validator->errors()->add('password', 'Password must contain at least one number.');
                }

                if (!preg_match('/[\W_]/', $password)) {
                    $validator->errors()->add('password', 'Password must contain at least one special character.');
                }
            }
        });
    }

}
