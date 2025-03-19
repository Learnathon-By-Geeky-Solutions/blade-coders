<x-backend-layout :title="__('Currencies')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Currencies') }}</h1>
        @can('currency.create')
            <x-primary-button class="create_currency" type="button">
                {{ __('Add Currency') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">#</th>
                        <th class="px-6 py-3" scope="col">{{ __('Code') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Label') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($currencies as $currency)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $currency->id }}</td>
                            <td class="px-6 py-3 text-left">{{ $currency->code }}</td>
                            <td class="px-6 py-3 text-left">{{ $currency->label }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $currency->id }}" :checked="$currency->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('currency.update')
                                    <x-action-button class="edit_currency" data-id="{{ $currency->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('currency.delete')
                                    <x-action-button class="delete_currency" data-id="{{ $currency->id }}"
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
                {{ $currencies->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="currency_modal" formId="currency_form" title="{{ __('Add Currency') }}"
        hidden-input-id="currency_id">
        <div class="gap-4 lg:flex 2xl:block">
            <!-- Currency Code -->
            <div class="mb-3">
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" :value="old('code')" required autofocus
                    placeholder="EUR" />
                <x-input-error class="error mt-2" :messages="$errors->get('code')" />
            </div>

            <!-- Currency Label -->
            <div class="mb-3">
                <x-input-label for="label" :value="__('Label')" />
                <x-text-input id="label" name="label" type="text" :value="old('label')" required
                    placeholder="Euro" />
                <x-input-error class="error mt-2" :messages="$errors->get('label')" />
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
                const modalSelector = '#currency_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#currency_form';
                const $currencyId = $('#currency_id');

                // Add Currency
                $('.create_currency').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Currency') }}");
                });

                // Edit Currency
                $(document).on('click', '.edit_currency', function() {
                    resetForm(formSelector);
                    const id = $(this).data('id');
                    showModal(modalSelector, modal, "{{ __('Edit Currency') }}");

                    sendRequest('GET', route('currencies.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.currency);
                            $currencyId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const currencyId = $currencyId.val();
                        return currencyId ? route("currencies.update", currencyId) : route("currencies.store");
                    },
                    () => $currencyId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('currencies.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Currency
                $(document).on('click', '.delete_currency', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('currencies.destroy', id);

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
