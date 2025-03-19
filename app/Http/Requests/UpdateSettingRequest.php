<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'app_name' => 'sometimes|string|max:32',
            'app_locale' => 'sometimes|string|max:16',
            'app_timezone' => 'sometimes|string|max:255',
            'website_logo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', /* dimensions:max_width=175,max_height=40 */
            'website_favicon' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', /* dimensions:max_width=32,max_height=32 */
            'mail_default' => 'nullable|string|max:255',
            'mail_mailers_smtp_host' => 'nullable|string|max:255',
            'mail_mailers_smtp_port' => 'nullable|string|max:255',
            'mail_mailers_smtp_username' => 'nullable|string|max:255',
            'mail_mailers_smtp_password' => 'nullable|string|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|string|max:255',
            'email_verification' => 'nullable|boolean',
            'default_role' => 'nullable|exists:roles,id',
            'pagination_limit' => 'sometimes|integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email_verification')) {
            $this->merge(['email_verification' => $this->has('email_verification')]);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'website_logo.dimensions' => 'The :attribute field has invalid dimensions. Valid dimension: :max_width x :max_height',
            'website_favicon.dimensions' => 'The :attribute field has invalid dimensions. Valid dimension: :max_width x :max_height',
        ];
    }
}
