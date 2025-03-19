<x-backend-layout :title="__('Ability Supports')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Ability Supports') }}</h1>
        @can('ability-support.create')
            <x-primary-button class="create_ability_support" type="button">
                {{ __('Add Ability Support') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Description') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abilitySupports as $abilitySupport)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $abilitySupport->name }}</td>
                            <td class="px-6 py-3 text-left">{{ Helper::contentLimit($abilitySupport->description) }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $abilitySupport->id }}" :checked="$abilitySupport->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('ability-support.update')
                                    <x-action-button class="edit_ability_support" data-id="{{ $abilitySupport->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Meeting Link Generate')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('ability-support.delete')
                                    <x-action-button class="delete_ability_support" data-id="{{ $abilitySupport->id }}"
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
                {{ $abilitySupports->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="ability_support_modal" formId="ability_support_form" title="{{ __('Add Ability Support') }}"
        hidden-input-id="ability_support_id">
        <div class="gap-4 lg:flex 2xl:block">
            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                    autocomplete="name" :placeholder="__('Enter Name')" />
                <x-input-error class="error mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea id="description" name="description" type="text" :value="old('description')" required
                    :placeholder="__('Enter Description')" />
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
                const modalSelector = '#ability_support_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#ability_support_form';
                const $ability_supportId = $('#ability_support_id');

                // Add Ability Support
                $('.create_ability_support').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Ability Support') }}");
                });

                // Edit Ability Support
                $(document).on('click', '.edit_ability_support', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Ability Support') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('ability-supports.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.abilitySupport);
                            $ability_supportId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const ability_supportId = $ability_supportId.val();
                        return ability_supportId ? route("ability-supports.update", ability_supportId) : route(
                            "ability-supports.store");
                    },
                    () => $ability_supportId.val() ? 'PUT' : 'POST',
                    response => {
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

                    sendRequest('POST', route('ability-supports.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Ability Support
                $(document).on('click', '.delete_ability_support', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('ability-supports.destroy', id);

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
