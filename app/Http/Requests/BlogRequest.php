<?php

namespace App\Http\Requests;

use App\Enums\BlogStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blog_category_id' => ['nullable', 'integer', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'min:3', 'max:128'],
            'subtitle' => ['nullable', 'string', 'min:3', 'max:255'],
            'status' => ['required', 'string', Rule::enum(BlogStatus::class)],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'sections' => ['array'],
            'sections.*.title' => ['required', 'string', 'min:3', 'max:128'],
            'sections.*.content' => ['nullable', 'string'],
        ];
    }
}
