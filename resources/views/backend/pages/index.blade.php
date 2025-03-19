<x-backend-layout :title="__('Pages')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Pages') }}</h1>
        @can('page.create')
            <x-primary-link href="{{ route('pages.create') }}">{{ __('Create Page') }}</x-primary-link>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Title') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Sub Title') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Status') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $page->title }}</td>
                            <td class="px-6 py-3 text-left"> {{ Str::limit($page->subtitle) }}</td>
                            <td class="px-6 py-3 text-left">
                            <x-badge :label="$page->status" />
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('page.update')
                                    <a class="inline-flex h-6 w-6 items-center justify-center rounded bg-green-200 text-center text-green-600 hover:bg-green-300"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" href="{{ route('pages.edit', $page->slug) }}">
                                        <i class="size-4" data-feather="edit"></i>
                                    </a>
                                @endcan
                                @can('page.delete')
                                    <x-action-button class="itemDelete" data-slug="{{ $page->slug }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ __('Delete') }}" type="button" color="red">
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
                {{ $pages->links() }}
            </div>
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function() {
                // taking confirmation while deleting page
                $('.itemDelete').click(function() {
                    const slug = $(this).data('slug');
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
                                url: route('pages.destroy', slug),
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
                                            cancelButtonColor: "#d33",
                                        }).then((result) => {
                                            location.reload()
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Can't deleted",
                                            icon: "info",
                                            text: response.message,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
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
