<x-backend-layout :title="__('Blog')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Blogs') }}</h1>
        @can('blog.create')
            <x-primary-link href="{{ route('blogs.create') }}">{{ __('Create Blog') }}</x-primary-link>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Title') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Category') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Author') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Status') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $blog->title }}</td>
                            <td class="px-6 py-3 text-left">
                                <x-badge :label="$blog->category->name"/>
                            </td>
                            <td class="px-6 py-3 text-left">
                                <div class="flex items-center">
                                    @if ($blog->createdBy->avatar)
                                        <div class="me-3">
                                            <img class="h-9 w-10 rounded-full" src="{{ Storage::url($blog->createdBy->avatar->path) }}" alt="img"/>
                                        </div>
                                    @endif
                                    <div>
                                        {{ $blog->createdBy->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-left">
                                <x-badge :label="$blog->status"/>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('blog.update')
                                <x-action-link data-bs-toggle="tooltip" data-bs-placement="top" :href="route('blogs.edit', $blog->id)"
                                    :data-bs-title="__('Edit')" color="green" icon="edit" />
                                @endcan
                                @can('blog.delete')
                                    <x-action-button class="delete_blog" data-id="{{ $blog->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        :data-bs-title="__('Delete')" type="button"
                                        color="red" icon="trash">
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
                {{ $blogs->links() }}
            </div>
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function() {
                // taking confirmation while deleting blog
                $(document).on('click', '.delete_blog', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('blogs.destroy', id);

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
