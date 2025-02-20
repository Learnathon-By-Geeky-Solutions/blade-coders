<section class="space-y-6">
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('Delete Account') }}</h4>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
            </p>
        </div>

        <x-danger-button x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form class="p-6" method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                </p>

                <div class="mt-6">
                    <x-input-label class="sr-only" for="password" value="{{ __('Password') }}" />

                    <x-text-input class="mt-1 block w-3/4" id="password" name="password" type="password"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</section>
