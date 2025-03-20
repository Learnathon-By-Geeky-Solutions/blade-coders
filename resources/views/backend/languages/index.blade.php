<x-backend-layout :title="__('Languages')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Languages') }}</h1>
        @can('language.create')
            <x-primary-button class="create_language" type="button">
                {{ __('Add Language') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">#</th>
                        <th class="px-6 py-3" scope="col">{{ __('Locale') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($languages as $language)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $language->id }}</td>
                            <td class="px-6 py-3 text-left">{{ $language->locale }}</td>
                            <td class="px-6 py-3 text-left">{{ $language->name }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $language->id }}" :checked="$language->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('language.update')
                                    <x-action-link data-id="{{ $language->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" type="button" :href="route('languages.translation', $language->id)" :data-bs-title="__('Translation')"
                                        color="blue" icon="globe" />

                                    <x-action-button class="edit_language" data-id="{{ $language->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('language.delete')
                                    <x-action-button class="delete_language" data-id="{{ $language->id }}"
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
                {{ $languages->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="language_modal" formId="language_form" title="{{ __('Add Language') }}"
        hidden-input-id="language_id">
        <div class="gap-4 lg:flex 2xl:block">
            <div class="mb-3">
                <x-input-label for="locale" :value="__('Locale')" />
                <x-text-input id="locale" name="locale" type="text" :value="old('locale')" required autofocus
                    autocomplete="username" placeholder="en" />
                <x-input-error class="error mt-2" :messages="$errors->get('locale')" />
            </div>

            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                    autocomplete="name" placeholder="English" />
                <x-input-error class="error mt-2" :messages="$errors->get('name')" />
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
                const modalSelector = '#language_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#language_form';
                const $languageId = $('#language_id');

                // Add Language
                $('.create_language').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Language') }}");
                });

                // Edit Language
                $(document).on('click', '.edit_language', function() {
                    resetForm(formSelector);
                    const id = $(this).data('id');
                    showModal(modalSelector, modal, "{{ __('Edit Language') }}");

                    sendRequest('GET', route('languages.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.language);
                            $languageId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const languageId = $languageId.val();
                        return languageId ? route("languages.update", languageId) : route("languages.store");
                    },
                    () => $languageId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('languages.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        location.reload()
                    });
                });

                // Delete Language
                $(document).on('click', '.delete_language', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('languages.destroy', id);

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
