<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $language = $this->route('language');

        return [
            'locale' => ['required', 'string', 'min:2', 'max:2', 'unique:languages,locale,'.$language?->id],
            'name' => ['required', 'string', 'unique:languages,name,'.$language?->id],
            'is_active' => ['boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->has('is_active')]);
    }
}
