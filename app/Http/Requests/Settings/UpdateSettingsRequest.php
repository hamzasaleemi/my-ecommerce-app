<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\BaseRequest;

class UpdateSettingsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
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
            'low_stock_threshold.required' => $this->errorMessages['required'],
            'low_stock_threshold.integer' => $this->errorMessages['integer'],
            'low_stock_threshold.min' => $this->errorMessages['min']
        ];
    }
}
