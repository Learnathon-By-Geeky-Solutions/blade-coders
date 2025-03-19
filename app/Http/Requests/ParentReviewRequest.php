<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_name' => ['required', 'string', 'max:64'],
            'parent_designation' => ['required', 'string', 'max:255'],
            'parent_avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'feedback' => ['required', 'string'],
            'rating' => ['required', 'max:5', 'min:0', 'decimal:1'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
