<x-backend-layout :title="__('Event Speakers')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Event Speakers') }}</h1>
        @can('event-speaker.create')
            <x-primary-button class="create_event_speaker" type="button">
                {{ __('Add Event Speaker') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Profile Picture') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('About') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventSpeakers as $eventSpeaker)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">
                                @if ($eventSpeaker->profilePicture)
                                    <img class="h-8 w-8 rounded-full"
                                        src="{{ Storage::url($eventSpeaker->profilePicture->path) }}"
                                        alt="{{ $eventSpeaker->name }}" />
                                @endif
                            </td>
                            <td class="px-6 py-3 text-left">{{ $eventSpeaker->name }}</td>
                            <td class="px-6 py-3 text-left">{{ Helper::contentLimit($eventSpeaker->about) }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $eventSpeaker->id }}" :checked="$eventSpeaker->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('event-speaker.update')
                                    <x-action-button class="edit_event_speaker" data-id="{{ $eventSpeaker->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('event-speaker.delete')
                                    <x-action-button class="delete_event_speaker" data-id="{{ $eventSpeaker->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Delete')"
                                        color="red" icon="trash" />
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-center" colspan="100%">{{ __('No Data Found!') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $eventSpeakers->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="event_speaker_modal" formId="event_speaker_form" title="{{ __('Add Event Speaker') }}"
        hidden-input-id="event_speaker_id" :multipart="true">
        <div class="gap-4 lg:flex 2xl:block">
            <div class="mb-3">
                <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                <x-file-upload id="profile_picture" name="profile_picture" accept="image/*" :value="old('profile_picture')"
                    required />
                <x-input-error class="error mt-2" :messages="$errors->get('profile_picture')" />
            </div>

            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                    autocomplete="name" placeholder="Enter Name" />
                <x-input-error class="error mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="about" :value="__('About')" />
                <x-textarea id="about" name="about" type="text" :value="old('about')" required
                    placeholder="Enter About" />
                <x-input-error class="error mt-2" :messages="$errors->get('about')" />
            </div>
        </div>

        <div class="mb-3">
            <div class="flex items-center gap-3">
                <x-checkbox id="is_active" name="is_active" :is-checked="old('is_active')" />
                <x-input-label class="!mb-0" for="is_active">{{ __('Is Active') }}</x-input-label>
            </div>
        </div>
    </x-app-modal>

    @push('scripts')
        <script>
            $(function() {
                const modalSelector = '#event_speaker_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#event_speaker_form';
                const $eventSpeakerId = $('#event_speaker_id');

                // Add Event Speaker
                $('.create_event_speaker').click(() => {
                    $(formSelector).find('input[name=profile_picture]').attr('required', true);

                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Event Speaker') }}");
                });

                // Edit Event Speaker
                $(document).on('click', '.edit_event_speaker', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Event Speaker') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('event-speakers.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.eventSpeaker);
                            $eventSpeakerId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const eventSpeakerId = $eventSpeakerId.val();
                        return eventSpeakerId ? route("event-speakers.update", eventSpeakerId) : route(
                            "event-speakers.store");
                    },
                    () => $eventSpeakerId.val() ? 'PUT' : 'POST',
                    (response) => {
                        if (response?.success) {
                            modal.hide();
                            location.reload();
                        }
                    },
                    error => {
                        if (error.status === 422) {
                            handleValidationError(error.responseJSON.errors)
                        }
                    }
                );

                // Toggle Is Active
                $('.is_active_toggle').change(function() {
                    let status = $(this).is(":checked");
                    let id = $(this).data('id');

                    sendRequest('POST', route('event-speakers.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Event Speaker
                $(document).on('click', '.delete_event_speaker', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('event-speakers.destroy', id);

                    toast('Are you sure?', "You won't be able to revert this!", 'warning', true, (result) => {
                        if (result.isConfirmed) {
                            sendRequest('POST', deleteUrl, {
                                _method: 'DELETE'
                            }, (response) => {
                                if (response.success) {
                                    toast('Deleted!', response.message, 'success', false, (
                                        result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    toast("Can't delete", response.message, 'warning', false);
                                }
                            }, (error) => {
                                toast('Error!', error.responseJSON?.message, 'error', false);
                            });
                        }
                    }, 'Yes, delete it!', 'Cancel');
                });
            });
        </script>
    @endpush
</x-backend-layout>
