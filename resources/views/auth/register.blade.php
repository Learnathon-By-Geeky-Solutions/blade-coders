<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="lg:flex 2xl:block gap-4">
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Enter Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Enter Confirm Password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mb-5">
            <div class="flex items-center gap-2">
                <input id="accept" type="checkbox" class="mr-1 w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2" name="accept">
                <label for="accept">
                    <span>
                      I agree to the
                      <a href="#" class="text-indigo-600 hover:text-indigo-600">Terms of Service</a>
                      and
                      <a href="#" class="text-indigo-600 hover:text-indigo-600">Privacy Policy.</a>
                    </span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('accept')" class="mt-2" />
        </div>

        <div class="grid">
            <x-primary-button>{{ __('Create Free Account') }}</x-primary-button>
        </div>

        <div class="flex justify-between mt-4">
            @if (Route::has('login'))
                <div class="mb-2">
                    {{ __('Already registered?') }}
                    <a class="text-indigo-600 hover:text-indigo-600" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </div>
            @endif
            @if (Route::has('password.request'))
                <div>
                    <a class="text-indigo-600 hover:text-indigo-600" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
