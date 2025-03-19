@use('\App\Enums\ResourceType')

<x-backend-layout :title="__('Resource')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Resources') }}</h1>
        @can('resource.create')
            <x-primary-button class="create_resource" type="button">
                {{ __('Create Resource') }}
            </x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('Title') }} </th>
                        <th class="px-6 py-3" scope="col">{{ __('Resource Type') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Is Active') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $resource)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $resource->title }}</td>
                            <td class="px-6 py-3 text-left">
                                <x-badge :label="$resource->type"/>
                            </td>
                            <td class="px-6 py-3 text-left">
                                <label>
                                    <x-toggle-input class="is_active_toggle" name="is_active"
                                        data-id="{{ $resource->id }}" :checked="$resource->is_active" />
                                </label>
                            </td>
                            <td class="px-6 py-3 text-left">
                                @if ($resource->type === ResourceType::FILE->value)
                                    @can('resource.view')
                                        <x-action-link data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{ __('View') }}"
                                            href="{{ Storage::url($resource->file->path) }}" target="_blank" color="blue">
                                            <i class="size-4" data-feather="eye"></i>
                                        </x-action-link>
                                    @endcan
                                @endif
                                @can('resource.update')
                                    <x-action-button class="edit_resource" data-id="{{ $resource->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ __('Edit') }}" type="button" color="green">
                                        <i class="size-4" data-feather="edit"></i>
                                    </x-action-button>
                                @endcan
                                @can('resource.delete')
                                    <x-action-button class="resource_delete" data-id="{{ $resource->id }}"
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
                {{ $resources->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="resource_modal" formId="resource_form" title="{{ __('Add Resource') }}" hidden-input-id="resource_id" :multipart="true">
        <div class="mb-3">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" :value="old('title')" required autocomplete="off"
                placeholder="ex: Neuroscience overview :PDF" />
            <x-input-error class="error mt-2" :messages="$errors->get('title')" />
        </div>

        <div class="mb-3">
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-check-inline">
                    <input type="radio" id="type_link" name="type" class="form-check-input" value="{{ ResourceType::LINK->value }}">
                    <label class="form-check-label" for="type_link">Give Link</label>
                </div>

                <div class="form-check form-check-inline">
                    <input type="radio" id="type_file" name="type" class="form-check-input" value="{{ ResourceType::FILE->value }}" checked>
                    <label class="form-check-label" for="type_file">Give File</label>
                </div>
            </div>
        </div>

        <div class="mb-3" id="link_container">
            <x-input-label for="link" :value="__('File Link')"/>
            <x-text-input id="link" name="link" type="url"
                          :value="old('link', $resource->link ?? '')"
                          :placeholder="__('ex: https://www.youtube.com/')"/>
            <x-input-error class="mt-2" :messages="$errors->get('link')"/>
        </div>

        <div class="mb-3" id="file_container">
            <x-input-label for="file" :value="__('File')"/>
            <x-file-upload id="file" name="file" accept="image/*,application/pdf,.doc,.docx,video/*" :value="old('file')"/>
            <x-input-error class="mt-2" :messages="$errors->get('file')"/>
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
            $(function() {
                const modalSelector = '#resource_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#resource_form';
                const $resourceId = $('#resource_id');

                $('input[name="type"]').change(function() {
                    let selectedType = $('input[name="type"]:checked').val();

                    if (selectedType === {{ ResourceType::LINK->value }}) {
                        $('#link_container').show();
                        $('#file_container').hide();
                        $('#link').prop('required', true);
                        $('#file').prop('required', false);
                        $('#file').val('');
                    } else if (selectedType === {{ ResourceType::FILE->value }}) {
                        $('#file_container').show();
                        $('#link_container').hide();
                        $('#link').prop('required', false);
                        $('#file').prop('required', true);
                        $('#link').val('');
                    }
                });

                // Trigger change event on page load to handle default selection
                $('input[name="type"]:checked').trigger('change');

                // Add Resource
                $('.create_resource').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add Resource') }}");
                });

                // Edit Resource
                $(document).on('click', '.edit_resource', function() {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Edit Resource') }}");

                    const id = $(this).data('id');
                    sendRequest('GET', route('resources.show', id), {}, (response) => {
                        if (response.success) {
                            populateForm(formSelector, response.resource);
                            $resourceId.val(id);

                            $('input[name="type"][value="' + response.resource.type + '"]').prop('checked', true).trigger('change');
                        }
                    });
                });

                submitForm(formSelector,
                    () => {
                        const resourceId = $resourceId.val();
                        return resourceId ? route("resources.update", resourceId) : route("resources.store");
                    },
                    () => $resourceId.val() ? 'PUT' : 'POST',
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

                    sendRequest('POST', route('resources.status', id), {
                        _method: 'PATCH',
                        status
                    }, (response) => {
                        if (response.success) {
                            location.reload()
                        }
                    });
                });

                // Delete Resource
                $(document).on('click', '.resource_delete', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('resources.destroy', id);

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
