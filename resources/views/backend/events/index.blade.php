<x-backend-layout :title="__('Events')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Events') }}</h1>
        @can('event.create')
            <x-primary-link href="{{ route('events.create') }}">{{ __('Create Event') }}</x-primary-link>
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
                    <th class="px-6 py-3" scope="col">{{ __('Status') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($events as $event)
                    <tr class="border-b border-gray-300">
                        <td class="px-6 py-3 text-left">
                            @if ($event->featuredImage)
                                <img src="{{ $event->featuredImage->path }}" alt="{{ $event->name }}"
                                     width="34" height="34">
                            @endif
                        </td>
                        <td class="px-6 py-3 text-left">{{ $event->name }}</td>
                        <td class="px-6 py-3 text-left">
                            {{ $event->short_brief ? Helper::contentLimit($event->short_brief) : '-' }}</td>
                        <td class="px-6 py-3 text-left">
                            {{ $event->status }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{--                            @can('event.view') --}}
                            {{--                                <x-action-link
                            {{--                                   data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="__('Edit')" --}}
                            {{--                                   :href="route('events.show', $event->id)" color="blue" icon="eye" /> --}}
                            {{--                            @endcan --}}
                            @can('event.update')
                                <x-action-link data-bs-toggle="tooltip" data-bs-placement="top"
                                               :href="route('events.edit', $event->id)"
                                               :data-bs-title="__('Edit')" color="green" icon="edit"/>
                            @endcan
                            @can('event.delete')
                                <x-action-button class="delete_event" data-id="{{ $event->id }}"
                                                 data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                                 :data-bs-title="__('Delete')"
                                                 color="red" icon="trash"/>
                            @endcan
                            @can('event.update')
                                <x-action-button class="zoom_event" data-id="{{ $event->id }}"
                                                 data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                                 :data-bs-title="__('Meeting Link Generate')"
                                                 color="blue" icon="link"/>
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
            $(function () {
                $(document).on('click', '.delete_event', function () {
                    const id = $(this).data('id');
                    const deleteUrl = route('events.destroy', id);

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

                $(document).on('click', '.zoom_event', function () {
                    const id = $(this).data('id');
                    const deleteUrl = route('events.zoom', id);

                    toast('Are you sure?', "You want to generate Zoom Meeting Link", 'info', true, (
                        result) => {
                        if (result.isConfirmed) {
                            sendRequest('POST', deleteUrl, {}, (response) => {
                                console.log(response)
                                // if (response.success) {
                                //     toast('Deleted!', response.message, 'success',
                                //         false, (
                                //             result) => {
                                //             if (result.isConfirmed) {
                                //                 location.reload();
                                //             }
                                //         });
                                // } else {
                                //     toast("Can't delete", response.message,
                                //         'warning', false);
                                // }
                            }, (error) => {
                                toast('Error!', error.responseJSON?.message, 'error', false);
                            });
                        }
                    }, 'Yes, Generate!', 'Cancel');
                });
            });
        </script>
    @endpush
</x-backend-layout>
