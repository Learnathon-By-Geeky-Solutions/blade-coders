<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BenefitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'is_active' => ['boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->has('is_active')]);
    }

    public function messages(): array
    {
        return [
            'icon.required_without' => __('Benefit icon is required.'),
        ];
    }
}
