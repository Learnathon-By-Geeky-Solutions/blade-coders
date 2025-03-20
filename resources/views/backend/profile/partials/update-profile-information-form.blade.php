<section>
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('Profile Information') }}</h4>
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">Avatar</h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <div class="me-3">
                            @if($user->avatar)
                                <img class="h-16 w-16 rounded-full" src="{{ asset($user->avatar->path) }}" alt="{{ $user->name }}"/>
                            @else
                                <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="{{ $user->name }}"/>
                            @endif
                        </div>
                        <div>
                            <input id="avatar" name="avatar" accept="image/png, image/jpeg" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-600 dark:file:text-violet-100 dark:hover:file:bg-violet-500">
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="name" :value="__('Name')"/>
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required
                                      autofocus
                                      autocomplete="name"/>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="email" :value="__('Email')"/>
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required
                                      autocomplete="username"/>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800"></div>
                <div class="flex flex-[3] items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition
                           x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>
