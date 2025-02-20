<section>
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('Update Password') }}</h4>
        </div>

        <form class="mt-6 space-y-6" method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input class="mt-1 block w-full" id="update_password_current_password"
                            name="current_password" type="password" autocomplete="current-password" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="update_password_password" :value="__('New Password')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input class="mt-1 block w-full" id="update_password_password" name="password"
                            type="password" autocomplete="new-password" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input class="mt-1 block w-full" id="update_password_password_confirmation"
                            name="password_confirmation" type="password" autocomplete="new-password" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800"></div>
                <div class="flex flex-[3] items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>
