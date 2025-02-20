<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => 'sometimes|string|max:255',
            'app_locale' => 'nullable|string|max:255',
            'app_timezone' => 'nullable|string|max:255',
            'pagination_limit' => 'nullable|integer',
        ];
    }
}
