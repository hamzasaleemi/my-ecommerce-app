<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseRequest;

class ProfileUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $this->user()->id . ',id',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => $this->errorMessages['required'],
            'name.max' => $this->errorMessages['max'],
            'email.required' => $this->errorMessages['required'],
            'email.email' => $this->errorMessages['email'],
            'email.max' => $this->errorMessages['max'],
            'email.unique' => $this->errorMessages['unique'],
        ];
    }
}
