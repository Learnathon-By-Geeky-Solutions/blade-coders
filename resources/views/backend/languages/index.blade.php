<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Languages') }}</h1>
        @can('language.create')
            <x-primary-button
                type="button"
                class="createItem"
            >
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
                <tbody class="divide-y">
                @forelse($languages as $language)
                    <tr class="border-b border-gray-300">
                        <td class="px-6 py-3 text-left">{{ $language->id }}</td>
                        <td class="px-6 py-3 text-left">{{ $language->locale }}</td>
                        <td class="px-6 py-3 text-left">{{ $language->name }}</td>
                        <td class="px-6 py-3 text-left">
                            <label>
                                <input
                                    type="checkbox"
                                    data-id="{{ $language->id }}"
                                    name="is_active"
                                    class="is_active_toggle toggle-switch"
                                    @checked($language->is_active)
                                />
                            </label>
                        </td>
                        <td class="px-6 py-3 text-left">
                            @can('language.update')
                                <x-action-link
                                    href="{{ route('languages.translation', $language->id) }}"
                                    color="blue"
                                    data-id="{{ $language->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="{{ __('Translation') }}"
                                    type="button">
                                    <i class="size-4" data-feather="globe"></i>
                                </x-action-link>
                                <x-action-button
                                    class="itemEdit"
                                    color="green"
                                    data-id="{{ $language->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="{{ __('Edit') }}"
                                    type="button">
                                    <i class="size-4" data-feather="edit"></i>
                                </x-action-button>
                            @endcan
                            @can('language.delete')
                                <x-action-button
                                    class="itemDelete"
                                    color="red"
                                    data-id="{{ $language->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="{{ __('Delete') }}"
                                    type="button">
                                    <i class="size-4" data-feather="trash"></i>
                                </x-action-button>
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

    <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-300">
                    <h5 class="font-bold text-gray-800" id="modalTitle">{{ __('Add Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="text-gray-700"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l-12 12"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="languageForm" method="POST" action="{{ route('languages.store') }}">
                    @csrf
                    <div class="px-6 py-4 overflow-y-auto space-y-3">
                        <div class="gap-4 lg:flex 2xl:block">
                            <div class="mb-3">
                                <x-input-label for="locale" :value="__('Locale')"/>
                                <x-text-input id="locale" name="locale" type="text" :value="old('locale')" required
                                              autofocus
                                              autocomplete="username" placeholder="en"/>
                                <x-input-error class="mt-2 error" :messages="$errors->get('locale')"/>
                            </div>

                            <div class="mb-3">
                                <x-input-label for="name" :value="__('Name')"/>
                                <x-text-input id="name" name="name" type="text" :value="old('name')" required
                                              autocomplete="name" placeholder="English"/>
                                <x-input-error class="mt-2 error" :messages="$errors->get('name')"/>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="flex items-center">
                                <input name="is_active" type="checkbox"
                                       class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                       id="is_active" @checked(old('is_active'))/>
                                <label for="is_active" class="ms-3">{{ __('Is Active') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 px-6 py-4 flex justify-end gap-3">
                        <x-secondary-button
                            type="button"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Submit') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                const modal = new bootstrap.Modal('#languageModal');
                const errors = @js($errors->count());
                const method = !!@js(old('_method'));
                const oldId = @js(old('id'));

                function showCreateModal() {
                    modal.show();
                    $('#modalTitle').text("{{ __('Create Language') }}");
                    $('#languageForm')
                        .attr('action', route('languages.store'))
                        .trigger("reset")
                        .find('input[name=_method], input[name=id]').remove();
                    $('#is_active').prop('checked', false);
                }

                function showEditModal(id) {
                    modal.show();
                    $('#modalTitle').text("{{ __('Edit Language') }}");
                    $('#languageForm')
                        .attr('action', route('languages.update', id))
                        .prepend('<input type="hidden" name="_method" value="patch" />')
                        .prepend('<input type="hidden" name="id" value="' + id + '" />');

                    $.get(route('languages.show', id), function (response) {
                        if (response.success) {
                            $('#locale').val(response.language.locale);
                            $('#name').val(response.language.name);
                            $('#is_active').prop('checked', response.language.is_active);
                        }
                    });
                }

                $('.createItem').click(function () {
                    $('.error').hide();
                    showCreateModal();
                })

                $('.itemEdit').click(function () {
                    $('.error').hide();
                    const id = $(this).data('id');
                    showEditModal(id);
                });

                if (errors) {
                    if (method && oldId) {
                        $('#languageForm').prepend('<input type="hidden" name="id" value="' + oldId + '" />');
                        showEditModal(oldId);
                    } else {
                        showCreateModal();
                    }
                }

                $('.is_active_toggle').change(function () {
                    var status = $(this).is(":checked");
                    var id = $(this).data('id');

                    $.ajax({
                        type: "POST",
                        url: route('languages.status', id),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {status},
                        success: function (response) {
                            if (response.status) {
                                location.reload()
                            }
                        }
                    });
                });

                $('.itemDelete').click(function () {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: "Are you sure?",
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
                                url: route('languages.destroy', id),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    _method: "DELETE"
                                },
                                success: function (response) {
                                    if (response.status) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            icon: "success",
                                            text: response.message,
                                        }).then((result) => {
                                            location.reload()
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Can't deleted",
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
