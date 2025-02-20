<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Currencies') }}</h1>
        @can('currency.create')
            <x-secondary-link onclick="currencyCreateModal.showModal()">{{ __('Create Currency') }}</x-secondary-link>
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
                                    <input
                                        type="checkbox"
                                        data-id="{{ $currency->id }}"
                                        name="is_active"
                                        class="is_active_toggle relative w-[2.3rem] h-5 p-px bg-gray-200 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:w-4 before:h-4 before:bg-white checked:before:bg-indigo-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200"
                                        @checked($currency->is_active)
                                    />
                                </label>
                            </td>
                            {{-- <td class="px-6 py-3 text-left">
                                @can('currency.update')
                                    <button
                                        class="inline-flex h-6 w-6 items-center justify-center rounded text-green-600 hover:text-green-300"
                                        data-id="{{ $currency->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Deactivate" type="button"
                                        itemToggle>
                                        <i class="size-6" data-feather="toggle-right"></i>
                                    </button>
                                @endcan
                            </td> --}}
                            <td class="px-6 py-3 text-left">
                                @if ($currency->is_created)
                                    @can('currency.update')
                                        <button
                                            class="inline-flex h-6 w-6 items-center justify-center rounded bg-green-200 text-center text-green-600 hover:bg-green-300"
                                            data-id="{{ $currency->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" type="button"
                                            itemEdit>
                                            <i class="size-4" data-feather="edit"></i>
                                        </button>
                                    @endcan
                                    @can('currency.delete')
                                        <button
                                            class="inline-flex h-6 w-6 items-center justify-center rounded bg-red-200 text-center text-red-600 hover:bg-red-300"
                                            data-id="{{ $currency->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" type="button"
                                            itemDelete>
                                            <i class="size-4" data-feather="trash"></i>
                                        </button>
                                    @endcan
                                @else
                                    <p>--</p>
                                @endif
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

    <!-- Currency create modal -->
    <dialog class="w-full max-w-md rounded backdrop:bg-black/65" id="currencyCreateModal">
        <div class="card relative px-6 py-4 shadow">
            <div class="mb-4">
                <h3 class="mr-8 text-xl font-bold">{{ __('Create new currency') }}</h3>
                <form class="block" method="dialog">
                    <button
                        class="absolute right-3 top-3 size-7 rounded-full border text-lg leading-3 shadow transition-all hover:bg-gray-300">
                        x
                    </button>
                </form>
            </div>

            <form method="POST">
                @csrf

                <div class="gap-4 lg:flex 2xl:block">
                    <!-- Currency Code -->
                    <div class="mb-3">
                        <x-input-label for="create_currency_code" :value="__('Code')" />
                        <x-text-input id="create_currency_code" name="code" type="text" :value="old('name')" required
                            autofocus placeholder="Enter Currency Code" />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <!-- Currency Label -->
                    <div class="mb-3">
                        <x-input-label for="create_currency_label" :value="__('Label')" />
                        <x-text-input id="create_currency_label" name="label" type="text" :value="old('email')" required
                            placeholder="Enter Label" />
                        <x-input-error class="mt-2" :messages="$errors->get('label')" />
                    </div>
                </div>

                <!-- Is Active -->
                <div class="mb-3">
                    <x-input-label for="create_currency_is_active" :value="__('Is Active')" />

                    <select
                        class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="create_currency_is_active" name="is_active" >
                        <option value="1" selected>True</option>
                        <option value="0">False</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                <div class="grid">
                    <x-primary-button>
                        {{ __('Create Currency') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Currency edit modal -->
    <dialog class="w-full max-w-md rounded backdrop:bg-black/65" id="currencyEditModal">
        <div class="card relative px-6 py-4 shadow">
            <div class="mb-4">
                <h3 class="mr-8 text-xl font-bold" id="title">{{ __('Edit Currency') }}</h3>
                <form class="block" method="dialog">
                    <button
                        class="absolute right-3 top-3 size-7 rounded-full border text-lg leading-3 shadow transition-all hover:bg-gray-300">
                        x
                    </button>
                </form>
            </div>

            <form method="POST" action="#">
                @csrf
                @method('PATCH')

                <!-- Code -->
                <div class="mb-3">
                    <x-input-label for="edit_currency_code" :value="__('Code')" />
                    <x-text-input id="edit_currency_code" name="code" type="text" :value="old('code')" required
                        autofocus placeholder="Enter Currency Code" />
                    <x-input-error class="mt-2" :messages="$errors->get('code')" />
                </div>

                <!-- Label -->
                <div class="mb-3">
                    <x-input-label for="edit_currency_label" :value="__('Label')" />
                    <x-text-input id="edit_currency_label" name="label" type="text" :value="old('label')" required placeholder="Enter Currency Label" />
                    <x-input-error class="mt-2" :messages="$errors->get('label')" />
                </div>

                <div class="grid">
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </dialog>


    @push('scripts')
        <script>
            $(function() {

                //Fetching and loading currency data while opening currencyEditModal
                $('button[itemEdit]').click(function() {
                    currencyEditModal.showModal()

                    let id = $(this).data('id');

                    $.get(route('currencies.show', id), function(response) {

                        if (response.success) {
                            $('#currencyEditModal form').attr('action', route('currencies.update', id));

                            $('#edit_currency_code').val(response.currency.code);
                            $('#edit_currency_label').val(response.currency.label);
                        }
                    })
                });

                //changing active status
                $('.is_active_toggle').change(function () {
                    var status = $(this).is(":checked");
                    var id = $(this).data('id');

                    $.ajax({
                        type: "POST",
                        url: route('currencies.status', id),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            status,
                            _method: "PATCH"
                        },
                        success: function (response) {
                            if (response.status) {
                                location.reload()
                            }
                        }
                    });
                });

                // taking confirmation while deleting currency
                $('button[itemDelete]').click(function() {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: "Delete Currency?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: route('currencies.destroy', id),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    _method: "DELETE"
                                },
                                success: function(response) {
                                    if (response.status) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            icon: "success",
                                            text: response.message,
                                            confirmButtonColor: "#3085d6",
                                        }).then((result) => {
                                            location.reload()
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Can't delete",
                                            icon: "info",
                                            text: response.message,
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
</x-backend-layout>
