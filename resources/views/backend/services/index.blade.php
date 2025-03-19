<x-backend-layout :title="__('Services')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Services') }}</h1>
        @can('service.create')
            <x-primary-link href="{{ route('services.create') }}">{{ __('Create Service') }}</x-primary-link>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Icon') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Short Brief') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">
                                @if ($service->icon)
                                    <img src="{{ $service->icon->path }}" alt="{{ $service->name }}" width="34"
                                        height="34">
                                @endif
                            </td>
                            <td class="px-6 py-3 text-left">{{ $service->name }}</td>
                            <td class="px-6 py-3 text-left">
                                {{ $service->short_brief ? Helper::contentLimit($service->short_brief) : '-' }}</td>
                            <td class="px-6 py-3 text-left">
                                {{--                                @can('service.view') --}}
                                {{--                                    <x-action-link
                                {{--                                        data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="__('Edit')" --}}
                                {{--                                        :href="route('services.show', $service->id)" color="blue" icon="eye" /> --}}
                                {{--                                @endcan --}}
                                @can('service.update')
                                    <x-action-link data-bs-toggle="tooltip" data-bs-placement="top" :href="route('services.edit', $service->id)"
                                        :data-bs-title="__('Edit')" color="green" icon="edit" />
                                @endcan
                                @can('service.delete')
                                    <x-action-button class="delete_service" data-id="{{ $service->id }}"
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
                $(document).on('click', '.delete_service', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('services.destroy', id);

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
