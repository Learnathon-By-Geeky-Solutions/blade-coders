<x-backend-layout :title="__('Benefits')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Benefits') }}</h1>
        @can('benefit.create')
            <x-primary-button class="create_benefit" type="button">
                {{ __('Add Benefit') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Icon') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Description') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($benefits as $benefit)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">
                                @if ($benefit->icon)
                                    <img class="h-8 w-8 rounded-full" src="{{ Storage::url($benefit->icon->path) }}"
                                        alt="{{ $benefit->name }}" />
                                @endif
                            </td>
                            <td class="px-6 py-3 text-left">{{ $benefit->name }}</td>
                            <td class="px-6 py-3 text-left">{{ Helper::contentLimit($benefit->description) }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $benefit->id }}" :checked="$benefit->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('benefit.update')
                                    <x-action-button class="edit_benefit" data-id="{{ $benefit->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('benefit.delete')
                                    <x-action-button class="delete_benefit" data-id="{{ $benefit->id }}"
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
                {{ $benefits->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="benefit_modal" formId="benefit_form" title="{{ __('Add Benefit') }}" hidden-input-id="benefit_id"
        :multipart="true">
        <div class="gap-4 lg:flex 2xl:block">
            <div class="mb-3">
                <x-input-label for="icon" :value="__('Icon')" />
                <x-file-upload id="icon" name="icon" accept="image/*" :value="old('icon')" required />
                <x-input-error class="error mt-2" :messages="$errors->get('icon')" />
            </div>

            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                    autocomplete="name" placeholder="Enter Name" />
                <x-input-error class="error mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea id="description" name="description" type="text" :value="old('description')" required
                    placeholder="Enter Description" />
                <x-input-error class="error mt-2" :messages="$errors->get('description')" />
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
                const modalSelector = '#benefit_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#benefit_form';
                const $benefitId = $('#benefit_id');

                // Add Benefit
                $('.create_benefit').click(() => {
                    $(formSelector).find('input[name=icon]').attr('required', true);

                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Benefit') }}");
                });

                // Edit Benefit
                $(document).on('click', '.edit_benefit', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Benefit') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('benefits.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.benefit);
                            $benefitId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const benefitId = $benefitId.val();
                        return benefitId ? route("benefits.update", benefitId) : route("benefits.store");
                    },
                    () => $benefitId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('benefits.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Benefit
                $(document).on('click', '.delete_benefit', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('benefits.destroy', id);

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
