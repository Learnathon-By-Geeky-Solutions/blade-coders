<?php

namespace App\Http\Requests;

use App\Enums\ServiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'short_brief' => ['required', 'string', 'max:255'],
            'background_image' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'youtube_link' => ['required', 'url', 'max:255'],
            'benefits' => ['required', 'array'],
            'benefits.*' => ['required', 'integer', 'exists:benefits,id'],
            'ability_supports' => ['required', 'array'],
            'ability_supports.*' => ['required', 'integer', 'exists:ability_supports,id'],
            'ability_support_image' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'our_processes' => ['required', 'array'],
            'our_processes.*' => ['required', 'integer', 'exists:our_processes,id'],
            'status' => [Rule::enum(ServiceStatus::class)],
            'price' => [Rule::requiredIf(fn () => ! $this->boolean('is_free'))],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->has('is_active')]);
    }
}
