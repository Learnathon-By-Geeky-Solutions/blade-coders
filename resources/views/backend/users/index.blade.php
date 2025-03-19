<x-backend-layout :title="__('Users')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Users') }}</h1>
        @can('user.create')
            <x-primary-button class="create_user" type="button">{{ __('Add new User') }}</x-primary-button>
        @endcan
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">#</th>
                        <th class="px-6 py-3" scope="col">{{ __('Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Email') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Assigned Roles') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Created At') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $user->id }}</td>
                            <td class="px-6 py-3 text-left">{{ $user->name }}</td>
                            <td class="px-6 py-3 text-left">{{ $user->email }}</td>
                            <td class="flex flex-col gap-1 px-6 py-3 text-left">
                                @foreach ($user->roles as $userRole)
                                    <span
                                        class="max-w-fit rounded border-solid bg-green-300 px-2 py-1 text-sm text-black">{{ $userRole->label ?? $userRole->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-3 text-left">{{ $user->created_at ?? '-' }}</td>
                            <td class="px-6 py-3 text-left">
                                @if ($user->id !== auth()->id())
                                    @can('user.update')
                                        <x-action-button class="edit_user" data-id="{{ $user->id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                            :data-bs-title="__('Edit')" color="green" icon="edit" />

                                        <x-action-button class="password_reset_link" data-id="{{ $user->id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                            :data-bs-title="__('Send Password Reset Link')" color="blue" icon="key" />
                                    @endcan
                                    @can('user.delete')
                                        <x-action-button class="delete_user" data-id="{{ $user->id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                            :data-bs-title="__('Delete')" color="red" icon="trash" />
                                    @endcan
                                @else
                                    <p>--</p>
                                @endif
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
                {{ $users->links() }}
            </div>
        </div>
    </x-card>

    <x-app-modal id="user_create_modal" formId="user_create_form" title="{{ __('Add User') }}">
        <div class="gap-4 lg:flex 2xl:block">
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="create_user_name" :value="__('Name')" />
                <x-text-input id="create_user_name" name="name" type="text" :value="old('name')" required autofocus
                    autocomplete="name" placeholder="ex: John Doe" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="create_user_email" :value="__('Email')" />
                <x-text-input id="create_user_email" name="email" type="email" :value="old('email')" required
                    autocomplete="username" placeholder="ex: johndoe@example.com" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="create_user_password" :value="__('Password')" />

                <x-text-input id="create_user_password" name="password" type="password" required
                    autocomplete="new-password" placeholder="********" />

                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="create_user_password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="create_user_password_confirmation" name="password_confirmation" type="password"
                    required autocomplete="new-password" placeholder="********" />

                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
            </div>

            <!-- Roles -->
            <div class="mb-3">
                <x-input-label for="create_user_role" :value="__('User Role')" />

                <select
                    class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                    id="create_user_role" name="roles">
                    <option value="" selected disabled>{{ __('Select User Role') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->label ?? $role->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('roles')" />
            </div>

            <div class="mb-3">
                <div class="flex items-center">
                    <input
                        class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="welcome_email" name="welcome_email" type="checkbox" @checked(old('welcome_email')) />
                    <label class="ms-3" for="welcome_email">{{ __('Send wlcome email to user?') }}</label>
                </div>
            </div>
        </div>
    </x-app-modal>

    <x-app-modal id="user_edit_modal" formId="user-edit_form" title="{{ __('Edit User') }}"
        hidden-input-id="user_id">
        <div class="gap-4 lg:flex 2xl:block">
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="edit_user_name" :value="__('Name')" />
                <x-text-input id="edit_user_name" name="name" type="text" :value="old('name')" required autofocus
                    autocomplete="name" placeholder="John Doe" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="edit_user_email" :value="__('Email')" />
                <x-text-input id="edit_user_email" name="email" type="email" :value="old('email')" required
                    autocomplete="username" placeholder="johndoe@example.com" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Roles -->
            <div class="mb-3">
                <x-input-label for="edit_user_role" :value="__('User Role')" />

                <select
                    class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                    id="edit_user_role" name="roles">
                    <option value="" selected disabled>{{ __('Select User Role') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->label ?? $role->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('roles')" />
            </div>
        </div>
    </x-app-modal>

    @push('scripts')
        <script>
            $(function() {
                const modalSelector = '#user_create_modal';
                const modal = new bootstrap.Modal(modalSelector);
                const formSelector = '#user_create_form';

                const editModalSelector = '#user_edit_modal';
                const editModal = new bootstrap.Modal(editModalSelector);
                const editFormSelector = '#user-edit_form';
                const $userId = $('#user_id');

                // Add User
                $('.create_user').click(() => {
                    resetForm(formSelector);
                    showModal(modalSelector, modal, "{{ __('Add User') }}");
                });

                // Edit User
                $(document).on('click', '.edit_user', function() {
                    resetForm(editFormSelector);
                    const id = $(this).data('id');
                    showModal(editModalSelector, editModal, "{{ __('Edit User') }}");

                    sendRequest('GET', route('users.edit', id), {}, (response) => {
                        if (response.success) {
                            populateForm(editFormSelector, response.user);
                            $userId.val(id);
                        }
                    });
                });

                submitForm(formSelector, () => {
                        return route("users.store");
                    },
                    () => 'POST',
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
                    });

                submitForm(
                    editFormSelector,
                    () => {
                        const userId = $userId.val();
                        return userId ? route("users.update", userId) : route("users.store");
                    },
                    () => $userId.val() ? 'PUT' : 'POST',
                    (response) => {
                        if (response?.success) {
                            editModal.hide();
                            location.reload();
                        }
                    },
                    error => {
                        if (error.status === 422) {
                            handleValidationError(error.responseJSON.errors)
                        }
                    });

                // Delete User
                $(document).on('click', '.delete_user', function() {
                    const id = $(this).data('id');
                    const deleteUrl = route('users.destroy', id);

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

                // taking confirmation while sending password reset link
                $('.password_reset_link').click(function() {
                    const id = $(this).data('id');
                    const resetUrl = route('password-reset-link.send', id);

                    toast('Are you sure?', "Sending a password resent link", 'warning', true, (result) => {
                        if (result.isConfirmed) {
                            sendRequest('POST', resetUrl, {}, (response) => {
                                if (response.success) {
                                    toast('Sent!', response.message, 'success', false, (
                                        result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    toast("Problem sending password reset link", response
                                        .message, 'warning', false);
                                }
                            }, (error) => {
                                toast('Error!', error.responseJSON?.message, 'error', false);
                            });
                        }
                    }, 'Yes, Send it!', 'Cancel');
                });
            });
        </script>
    @endpush
</x-backend-layout>
