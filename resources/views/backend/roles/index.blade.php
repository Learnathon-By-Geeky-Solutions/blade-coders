<x-backend-layout :title="__('Roles')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Roles') }}</h1>
        @can('role.create')
            <x-primary-link href="{{ route('roles.create') }}">{{ __('Add Role') }}</x-primary-link>
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
                <tbody>
                    @forelse($roles as $role)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $role->id }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->label ?? '-' }}</td>
                            <td class="px-6 py-3 text-left">
                                @can('role.update')
                                    <x-action-link data-bs-toggle="tooltip" data-bs-placement="top" :href="route('roles.edit', $role->id)"
                                        :data-bs-title="__('Edit')" color="green" icon="edit" />
                                @endcan
                                @can('role.delete')
                                    <x-action-button class="delete_role" data-id="{{ $role->id }}"
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
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function() {
                $(document).on('click', '.delete_role', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('roles.destroy', id);

                    toast('Are you sure?', "You won't be able to revert this!", 'warning', true, (
                        result) => {
                        if (result.isConfirmed) {
                            sendRequest('POST', deleteUrl, {
                                _method: 'DELETE'
                            }, (response) => {
                                if (response.success) {
                                    toast('Deleted!', response.message, 'success',
                                        false, (
                                            result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                } else {
                                    toast("Can't delete", response.message,
                                        'warning', false);
                                }
                            }, (error) => {
                                toast('Error!', error.responseJSON?.message,
                                    'error', false);
                            });
                        }
                    }, 'Yes, delete it!', 'Cancel');
                });
            });
        </script>
    @endpush
</x-backend-layout>
