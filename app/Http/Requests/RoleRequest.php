<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $role = $this->route('role');

        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:roles,name,'.$role?->id],
            'label' => ['nullable', 'string', 'min:3', 'max:255'],
            'permissions' => ['nullable', 'array'],
        ];
    }
}
