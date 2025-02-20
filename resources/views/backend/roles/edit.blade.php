<x-backend-layout>
    <div class="mb-4 flex items-center justify-between border-b border-gray-300 pb-4">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Edit Role') }}</h1>
        <x-secondary-link href="{{ route('roles.index') }}">{{ __('Back') }}</x-secondary-link>
    </div>

    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('put')
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-3">
                <x-text-input id="name" name="name" type="text" :value="$role->name" required autofocus autocomplete="username" placeholder="Enter Name *" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div class="mb-5">
                <x-text-input id="label" name="label" type="text" :value="$role->label" required autofocus autocomplete="label" placeholder="Enter Label" />
                <x-input-error class="mt-2" :messages="$errors->get('label')" />
            </div>
        </div>

        <h2 class="mb-3 text-xl">{{ __('Permissions') }}</h2>
        <div class="mb-4 grid grid-cols-3 gap-4">
            @foreach ($permissions as $key => $permission)
                <div class="rounded-lg border bg-white p-4 shadow">
                    @if (!auth()->user()?->roles->pluck('name')->contains($role->name) || $key != 'Role')
                        <h3 class="mb-3 text-lg">{{ $key }}</h3>
                        <ul class="space-y-2">
                            @foreach ($permission as $item)
                                <li>
                                    <label class="inline-flex items-center" for="{{ $item['id'] }}">
                                        <input
                                            class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                            id="{{ $item['id'] }}" name="permissions[]" type="checkbox"
                                            value="{{ $item['id'] }}" @checked(old('permissions', $role->permissions->pluck('id')->contains($item['id'])))>
                                        <span class="ms-2 inline-block">{{ $item['label'] }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mb-3 flex items-center gap-2">
                            <h3 class="text-lg">{{ $key }}</h3>
                            <div data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{ __('You cann\'t change your own Role Permission.') }}">
                                <span class="size-5" data-feather="help-circle"></span>
                            </div>
                        </div>
                        <ul class="space-y-2">
                            @foreach ($permission as $item)
                                <input name="permissions[]" type="hidden" value="{{ $item['id'] }}">
                                <li>
                                    <label class="inline-flex items-center">
                                        <input
                                            class="h-4 w-4 rounded border-gray-300 bg-white text-gray-600 focus:outline-none focus:ring-0 focus:ring-gray-600"
                                            type="checkbox" @checked(old('permissions', $role->permissions->pluck('id')->contains($item['id']))) disabled>
                                        <span class="ms-2 inline-block">{{ $item['label'] }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="grid">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-backend-layout>
