<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    protected array $errorMessages = [];

    public function __construct()
    {
        parent::__construct();

        $this->errorMessages = [
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'email' => 'The :attribute must be a valid email address.',
            'exists' => 'The selected :attribute does not exist.',
            'unique' => 'The :attribute has already been taken.',
            'integer' => 'The :attribute must be an integer.',
            'min' => 'The :attribute must be at least :min.',
        ];
    }
}
