<?php

namespace App\Http\Requests;

use App\Enums\ResourceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResourceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:128'],
            'type' => ['string', Rule::enum(ResourceType::class)],
            'file' => [ Rule::requiredIf($this->type === ResourceType::FILE),'nullable', 'file', 'mimes:jpeg,png,jpg,pdf,doc,docx,mp4,avi,mov', 'max:100000'],
            'link' => [Rule::requiredIf($this->type === ResourceType::LINK),'nullable', 'string', 'min:3', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->has('is_active')]);
    }
}
