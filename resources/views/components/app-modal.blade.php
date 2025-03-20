@props([
    'id',
    'title',
    'formId',
    'formMethod' => 'POST',
    'formAction' => '',
    'hiddenInputId' => 'id',
    'hiddenInputValue' => '',
    'multipart' => false
])

<div class="modal fade" id="{{ $id }}" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="flex items-center justify-between border-b border-gray-300 px-6 py-4">
                <h5 class="modal-title text-lg font-semibold text-gray-800" id="{{ $id }}Label">
                    {{ $title }}
                </h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <svg class="text-gray-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="{{ $formId }}" method="{{ $formMethod }}" action="{{ $formAction }}" @if($multipart) enctype="multipart/form-data" @endif>
                @csrf
                @if ($formMethod == 'PUT')
                    @method('PUT')
                @endif
                @if ($hiddenInputId)
                    <input id="{{ $hiddenInputId }}" type="hidden" value="{{ $hiddenInputValue }}">
                @endif
                <div class="space-y-3 overflow-y-auto px-6 py-4">
                    {{ $slot }}
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-300 px-6 py-4">
                    <x-secondary-button data-bs-dismiss="modal" type="button">{{ __('Close') }}</x-secondary-button>
                    <x-primary-button>{{ __('Submit') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
