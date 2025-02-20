<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Roles') }}</h1>
        @can('role.create')
            <x-secondary-link href="{{ route('roles.create') }}">{{ __('Create Role') }}</x-secondary-link>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">#</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Label') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($roles as $role)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $role->id }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->label ?? '-' }}</td>
                            <td class="px-6 py-3 text-left">
                                @can('role.update')
                                    <a class="inline-flex h-6 w-6 items-center justify-center rounded bg-green-200 text-center text-green-600 hover:bg-green-300"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"
                                        href="{{ route('roles.edit', $role->id) }}">
                                        <i class="size-4" data-feather="edit"></i>
                                    </a>
                                @endcan
                                @can('role.delete')
                                    <button
                                        class="inline-flex h-6 w-6 items-center justify-center rounded bg-red-200 text-center text-red-600 hover:bg-red-300"
                                        data-id="{{ $role->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Delete" type="button" itemDelete>
                                        <i class="size-4" data-feather="trash"></i>
                                    </button>
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
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function() {
                $('button[itemDelete]').click(function() {
                    const id = $(this).data('id');

                    // if(confirm('Are you sure you want to delete this item?')) {
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
                                url: route('roles.destroy', id),
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
                    // }
                });
            });
        </script>
    @endpush
</x-backend-layout>
