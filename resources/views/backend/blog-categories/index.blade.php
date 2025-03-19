<x-backend-layout :title="__('Blog Category')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Blog Categories') }}</h1>
        @can('blog_category.create')
            <x-primary-button type="button" class="create_blog_category">
                {{ __('Add Category') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Category Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Created At') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogCategories as $blogCategory)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $blogCategory->name }}</td>
                            <td class="px-6 py-3 text-left">{{ $blogCategory->created_at }}</td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{  $blogCategory->id }}" :checked="$blogCategory->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @can('blog_category.update')
                                    <x-action-button class="edit_blog_category" data-id="{{ $blogCategory->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" type="button" :data-bs-title="__('Edit')"
                                        color="green" icon="edit" />
                                @endcan
                                @can('blog_category.delete')
                                    <x-action-button class="delete_blog_category" data-id="{{ $blogCategory->id }}"
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
                {{ $blogCategories->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="blog_category_modal" formId="blog_category_form" title="{{ __('Add Blog Category') }}"
        hidden-input-id="blog_category_id" :multipart="false">

        <div class="mb-3">
            <x-input-label for="name" :value="__('Category Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                placeholder="ex: Shopping" />
            <x-input-error class="mt-2 error" :messages="$errors->get('name')" />
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
            $(function () {
                const modalSelector = '#blog_category_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#blog_category_form';
                const $blogCategoryId = $('#blog_category_id');

                // Add Blog Category
                $('.create_blog_category').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Blog Category') }}");
                });

                // Edit Blog Category
                $(document).on('click', '.edit_blog_category', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Blog Category') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('blog-categories.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.blogCategory);
                            $blogCategoryId.val(id);
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const blogCategoryId = $blogCategoryId.val();
                        console.log(blogCategoryId);
                        return blogCategoryId ? route("blog-categories.update", blogCategoryId) : route("blog-categories.store");
                    },
                    () => $blogCategoryId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('blog-categories.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Blog Category
                $(document).on('click', '.delete_blog_category', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('blog-categories.destroy', id);

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
