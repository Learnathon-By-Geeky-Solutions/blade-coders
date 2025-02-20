<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Users') }}</h1>
        @can('user.create')
            <x-secondary-link onclick="userCreateModal.showModal()">{{ __('Create User') }}</x-secondary-link>
        @endcan
    </x-slot>

    <div class="card shadow">
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
                <tbody class="divide-y">
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
                                        <button
                                            class="inline-flex h-6 w-6 items-center justify-center rounded bg-green-200 text-center text-green-600 hover:bg-green-300"
                                            data-id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Edit" type="button" itemEdit>
                                            <i class="size-4" data-feather="edit"></i>
                                        </button>

                                        <button
                                            class="inline-flex h-6 w-6 items-center justify-center rounded bg-blue-200 text-center text-blue-600 hover:bg-blue-300"
                                            data-id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Send Password Reset Link" type="button" passwordResetLink>
                                            <i class="size-4" data-feather="key"></i>
                                        </button>
                                    @endcan
                                    @can('user.delete')
                                        <button
                                            class="inline-flex h-6 w-6 items-center justify-center rounded bg-red-200 text-center text-red-600 hover:bg-red-300"
                                            data-id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Delete" type="button" itemDelete>
                                            <i class="size-4" data-feather="trash"></i>
                                        </button>
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
    </div>


    <!-- User create modal -->
    <dialog class="w-full max-w-md rounded backdrop:bg-black/65" id="userCreateModal">
        <div class="card relative px-6 py-4 shadow">
            <div class="mb-4">
                <h3 class="mr-8 text-xl font-bold">{{ __('Create new user') }}</h3>
                <form class="block" method="dialog">
                    <button
                        class="absolute right-3 top-3 size-7 rounded-full border text-lg leading-3 shadow transition-all hover:bg-gray-300">
                        x
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="gap-4 lg:flex 2xl:block">
                    <!-- Name -->
                    <div class="mb-3">
                        <x-input-label for="create_user_name" :value="__('Name')" />
                        <x-text-input id="create_user_name" name="name" type="text" :value="old('name')" required
                            autofocus autocomplete="name" placeholder="Enter Name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="create_user_email" :value="__('Email')" />
                        <x-text-input id="create_user_email" name="email" type="email" :value="old('email')" required
                            autocomplete="username" placeholder="Enter Email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="create_user_password" :value="__('Password')" />

                    <x-text-input id="create_user_password" name="password" type="password" required
                        autocomplete="new-password" placeholder="Enter Password" />

                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="create_user_password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="create_user_password_confirmation" name="password_confirmation" type="password"
                        required autocomplete="new-password" placeholder="Enter Confirm Password" />

                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Roles -->
                <div class="mb-3">
                    <x-input-label for="create_user_role" :value="__('User Role')" />

                    <select
                        class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="create_user_role" name="role">
                        <option value="none" selected disabled hidden>{{ __('Select User Role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->label ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                </div>

                {{-- <div class="mb-3">
                    <div class="flex">
                        <input type="checkbox"
                            class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                            id="default-checkbox" />
                        <label for="default-checkbox" class="text-gray-500 ms-3 ">{{__('Select to send wlcome email to user')}}x</label>
                    </div>
                </div> --}}

                <div class="grid">
                    <x-primary-button>
                        {{ __('Create Account') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </dialog>


    <!-- User edit modal -->
    <dialog class="w-full max-w-md rounded backdrop:bg-black/65" id="userEditModal">
        <div class="card relative px-6 py-4 shadow">
            <div class="mb-4">
                <h3 class="mr-8 text-xl font-bold" id="title">{{ __('Edit User') }}</h3>
                <form class="block" method="dialog">
                    <button
                        class="absolute right-3 top-3 size-7 rounded-full border text-lg leading-3 shadow transition-all hover:bg-gray-300">
                        x
                    </button>
                </form>
            </div>

            <form method="POST" action="#">
                @csrf
                @method('PATCH')

                <div class="gap-4 lg:flex 2xl:block">
                    <!-- Name -->
                    <div class="mb-3">
                        <x-input-label for="edit_user_name" :value="__('Name')" />
                        <x-text-input id="edit_user_name" name="name" type="text" :value="old('name')" required
                            autofocus autocomplete="name" placeholder="Enter Name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="edit_user_email" :value="__('Email')" />
                        <x-text-input id="edit_user_email" name="email" type="email" :value="old('email')" required
                            autocomplete="username" placeholder="Enter Email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <div class="mb-3">
                    <x-input-label for="edit_user_role" :value="__('User Role')" />
                    <select
                        class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="edit_user_role" name="role">
                        <option value="none" selected disabled hidden>{{ __('Select User Role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role['id'] }}">
                                {{ $role->label ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                </div>

                {{-- <div class="mb-3">
                    <div class="flex">
                        <input type="checkbox"
                            class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                            id="default-checkbox" />
                        <label for="default-checkbox" class="text-gray-500 ms-3 ">{{__('Select to send wlcome email to user')}}x</label>
                    </div>
                </div> --}}

                <div class="grid">
                    <x-primary-button>
                        {{ __('Update Account') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </dialog>


    @push('scripts')
        <script>
            $(function() {
                //Fetching and loading user data while opening userEditModal
                $('button[itemEdit]').click(function() {
                    userEditModal.showModal()

                    let id = $(this).data('id');

                    $.get(route('users.show', id), function(response) {
                        // console.log(response.user)

                        if (response.success) {
                            $('#userEditModal form').attr('action', route('users.update', id));

                            $('#edit_user_name').val(response.user.name);
                            $('#edit_user_email').val(response.user.email);

                            response.user.roles.forEach(function(item) {
                                $('#edit_user_role').find('option[value="' + item.id + '"]')
                                    .attr("selected", true);
                            });
                        }
                    })
                });

                // taking confirmation while deleting user
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
                                url: route('users.destroy', id),
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
                                            title: "Can't delete",
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

                // taking confirmation while sending password reset link
                $('button[passwordResetLink]').click(function() {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "Sending a password resent link",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, send!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: route('password-reset-link.send', id),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    _method: "POST"
                                },
                                success: function(response) {
                                    if (response.status) {
                                        Swal.fire({
                                            title: "Sent!",
                                            icon: "success",
                                            text: response.message,
                                            confirmButtonColor: "#3085d6",
                                        })
                                    } else {
                                        Swal.fire({
                                            title: "Problem sending password reset link",
                                            icon: "info",
                                            text: response.message,
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
