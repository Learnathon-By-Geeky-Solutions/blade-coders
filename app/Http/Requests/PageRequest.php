<?php

namespace App\Http\Requests;

use App\Enums\PageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $page = $this->route('page');

        return [
            'title' => ['required', 'string', 'max:64', 'unique:pages,title,'.$page?->id],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'content' => ['nullable', 'string'],
            'status' => ['string', Rule::enum(PageStatus::class)],
        ];
    }
}
