<?php

namespace App\Http\Requests;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'featured_image' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'short_brief' => ['required', 'string', 'max:200'],
            'background_image' => [Rule::requiredIf(fn () => $this->isMethod('post')), 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'price' => [Rule::requiredIf(fn () => ! $this->boolean('is_free'))],
            'location' => ['required', 'string', 'max:255'],
            'button_link' => ['nullable', 'url'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'youtube_link' => ['required', 'url'],
            'status' => ['required', Rule::enum(EventStatus::class)],
            'meeting_link' => ['nullable', 'url', 'regex:/^https:\/\/zoom\.us\/j\/\d+$/'],
            'service_id' => ['required', 'exists:services,id'],
            'event_type_id' => ['required', 'exists:event_types,id'],

            'event_speakers' => ['required', 'array'],
            'event_speakers.*' => ['required', 'exists:event_speakers,id'],

            'agenda' => ['required', 'array'],
            'agenda.*.title' => ['required', 'string', 'max:255'],
            'agenda.*.start_time' => ['required', 'date'],
            'agenda.*.end_time' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'meeting_link.regex' => __('The link must be a valid ZOOM Meeting URL.'),
        ];
    }
}
