<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Parent Reviews') }}</h1>
        @can('parent_review.create')
            <x-primary-button
                type="button"
                class="createItem"
            >
                {{ __('Create Parent Review') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                <tr class="border-b border-gray-300">
                    <th class="px-6 py-3" scope="col">{{ __('Parent Name') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Parent Designation') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Feedback') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Rating') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                    <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($parentReviews as $key => $parentReview)
                    <tr class="border-b border-gray-300">
                        <td class="px-6 py-3 text-left">
                            <div class="flex items-center">
                                @if ($parentReview->parentAvatar)
                                    <div class="me-3">
                                            <img class="h-9 w-10 rounded-full" src="{{ Storage::url($parentReview->parentAvatar->path) }}" alt="img"/>
                                    </div>
                                @endif
                                <div>
                                    {{ $parentReview->parent_name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-left">{{ $parentReview->parent_designation }}</td>
                        <td class="px-6 py-3 text-left">{{ Str::limit($parentReview->feedback, 50) }}</td>
                        <td class="px-6 py-3 text-left">
                            <x-rating-input name="ratings[{{$key}}]" :value="$parentReview->rating" :disabled="true"/>
                        </td>
                        <td class="px-6 py-3 text-left">
                            <label>
                                <input
                                    type="checkbox"
                                    data-id="{{ $parentReview->id }}"
                                    name="is_active"
                                    class="is_active_toggle toggle-switch"
                                    @checked($parentReview->is_active)
                                />
                            </label>
                        </td>
                        <td class="px-6 py-3 text-left">
                            @can('parent_review.update')
                                <x-action-button
                                    class="itemEdit"
                                    color="green"
                                    data-id="{{ $parentReview->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="{{ __('Edit') }}"
                                    type="button">
                                    <i class="size-4" data-feather="edit"></i>
                                </x-action-button>
                            @endcan
                            @can('parent_review.delete')
                                <x-action-button
                                    class="itemDelete"
                                    color="red"
                                    data-id="{{ $parentReview->id }}"
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
                {{ $parentReviews->links() }}
            </div>
        </div>
    </x-card>

    <div class="modal fade" id="parentReviewModal" tabindex="-1" aria-labelledby="parentReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-300">
                    <h5 class="font-bold text-gray-800" id="modalTitle">{{ __('Add Parent Review') }}</h5>
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
                <form id="parentReviewForm" method="POST" action="{{ route('parent-reviews.store') }}", enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-4 overflow-y-auto space-y-3">
                        <div class="gap-4 lg:flex 2xl:block">
                            <div class="mb-3">
                                <x-input-label for="parent-name" :value="__('Parent Name')"/>
                                <x-text-input id="parent-name" name="parent_name" type="text" :value="old('parent_name')" required autofocus placeholder="ex: John Doe"/>
                                <x-input-error class="mt-2 error" :messages="$errors->get('parent_name')"/>
                            </div>

                            <div class="mb-3">
                                <x-input-label for="parent-designation" :value="__('Parent Designation')"/>
                                <x-text-input id="parent-designation" name="parent_designation" type="text" :value="old('parent_designation')" required placeholder="ex: Parent of a disabled child"/>
                                <x-input-error class="mt-2 error" :messages="$errors->get('parent_designation')"/>
                            </div>
                        </div>

                        <div class="mb-0 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                            <div class="flex-1">
                                <x-input-label for="parent-avatar" :value="__('Parent Avatar')"/>
                            </div>
                            <div class="flex-[3]">
                                <div class="flex items-center">
                                    <div id="parent-avatar-placeholder" class="me-3 hidden">
                                        <img class="h-15 w-16 rounded-full" src="" alt="img"/>
                                    </div>
                                    <div>
                                        <input id="parent-avatar" name="parent_avatar" accept="image/png, image/jpeg" type="file"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-600 dark:file:text-violet-100 dark:hover:file:bg-violet-500">
                                        <x-input-error class="mt-2" :messages="$errors->get('parent_avatar')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="feedback" :value="__('Feedback')"/>
                            <x-textarea-input id="feedback" name="feedback" type="text" :value="old('feedback')" required/>
                            <x-input-error class="mt-2 error" :messages="$errors->get('feedback')"/>
                        </div>

                        <div class="mb-0 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                            <div class="flex-1">
                                <x-input-label for="rating" :value="__('Rating')"/>
                            </div>
                            <div class="flex-[3]">
                                <x-rating-input name="rating" :value="old('rating', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('rating')" />
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
                const modal = new bootstrap.Modal('#parentReviewModal');
                const errors = @js($errors->count());
                const method = !!@js(old('_method'));
                const oldId = @js(old('id'));

                function showCreateModal() {
                    modal.show();
                    $('#modalTitle').text("{{ __('Add Parent Review') }}");
                    $('#parentReviewForm')
                        .attr('action', route('parent-reviews.store'))
                        .trigger("reset")
                        .find('input[name=_method], input[name=id]').remove();
                }

                function showEditModal(id, error = false) {
                    modal.show();

                    $('#modalTitle').text("{{ __('Edit Parent Review') }}");
                    $('#parentReviewForm')
                        .attr('action', route('parent-reviews.update', id))
                        .prepend('<input type="hidden" name="_method" value="patch" />')
                        .prepend('<input type="hidden" name="id" value="' + id + '" />');

                    if (error) return;

                    $.get(route('parent-reviews.show', id), function (response) {
                        if (response.success) {
                            $('#parent-name').val(response.parentReview.parent_name);
                            $('#parent-designation').val(response.parentReview.parent_designation);
                            $('#feedback').val(response.parentReview.feedback);

                            if (response.parentReview.parent_avatar) {
                                $('#parent-avatar-placeholder').removeClass('hidden');
                                $('#parent-avatar-placeholder img').attr('src', response.parentReview.parent_avatar.path );
                            } else {
                                $('#parent-avatar-placeholder').addClass('hidden');
                                $('#parent-avatar-placeholder img').attr('src', "");
                            }

                            $(`input[name="rating"]`).attr('checked', false);
                            $(`input[name="rating"][value="${response.parentReview.rating}"]`).attr('checked', true);
                            $('#is_active').prop('checked', response.parentReview.is_active);
                        }
                    });
                }

                $('.createItem').click(function () {
                    $('.error').hide();
                    $('#parent-avatar-placeholder').addClass('hidden');
                    $('#parent-avatar-placeholder img').attr('src', "");
                    $(`input[name="rating"]`).attr('checked', false);
                    $(`input[name="rating"][value="0.0"]`).attr('checked', true);
                    showCreateModal();
                })

                $('.itemEdit').click(function () {
                    $('.error').hide();
                    const id = $(this).data('id');
                    showEditModal(id);
                });

                if (errors) {
                    if (method && oldId) {
                        $('#parentReviewForm').prepend('<input type="hidden" name="id" value="' + oldId + '" />');
                        showEditModal(oldId, true);
                    } else {
                        showCreateModal();
                    }
                }

                $('.is_active_toggle').change(function () {
                    var status = $(this).is(":checked");
                    var id = $(this).data('id');

                    $.ajax({
                        type: "PATCH",
                        url: route('parent-reviews.status', id),
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
                                url: route('parent-reviews.destroy', id),
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
