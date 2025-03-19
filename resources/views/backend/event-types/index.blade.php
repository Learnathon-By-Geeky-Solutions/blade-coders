<x-backend-layout :title="__('Event Types')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Event Types') }}</h1>
        @can('event-type.create')
            <x-primary-button class="create_event_type" type="button">
                {{ __('Add Event Type') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventTypes as $eventType)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $eventType->name }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $eventType->id }}" :checked="$eventType->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('event-type.update')
                                    <x-action-button class="edit_event_type" data-id="{{ $eventType->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('event-type.delete')
                                    <x-action-button class="delete_event_type" data-id="{{ $eventType->id }}"
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
                {{ $eventTypes->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="event_type_modal" formId="event_type_form" title="{{ __('Add Event Type') }}"
        hidden-input-id="event_type_id" :multipart="true">
        <div class="gap-4 lg:flex 2xl:block">
            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                    autocomplete="name" placeholder="Enter Name" />
                <x-input-error class="error mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <div class="flex items-center gap-3">
                    <x-checkbox id="is_active" name="is_active" :is-checked="old('is_active')" />
                    <x-input-label class="!mb-0" for="is_active">{{ __('Is Active') }}</x-input-label>
                </div>
            </div>
        </div>
    </x-app-modal>

    @push('scripts')
        <script>
            $(function() {
                const modalSelector = '#event_type_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#event_type_form';
                const $eventTypeId = $('#event_type_id');

                // Add Event Type
                $('.create_event_type').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Event Type') }}");
                });

                // Edit Event Type
                $(document).on('click', '.edit_event_type', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Event Type') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('event-types.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.eventType);
                            $eventTypeId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const eventTypeId = $eventTypeId.val();
                        return eventTypeId ? route("event-types.update", eventTypeId) : route("event-types.store");
                    },
                    () => $eventTypeId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('event-types.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Event Type
                $(document).on('click', '.delete_event_type', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('event-types.destroy', id);

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
