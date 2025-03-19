<x-guest-layout :title="__('Register')">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="gap-4 lg:flex 2xl:block">
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                    autocomplete="name" placeholder="Enter Name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" :value="old('email')" required
                    autocomplete="username" placeholder="Enter Email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" name="password" type="password" required autocomplete="new-password"
                placeholder="Enter Password" />

            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                autocomplete="new-password" placeholder="Enter Confirm Password" />

            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mb-5">
            <div class="flex items-center gap-2">
                <input
                    class="mr-1 h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                    id="accept" name="accept" type="checkbox">
                <label for="accept">
                    <span>
                        I agree to the
                        <a class="text-indigo-600 hover:text-indigo-600" href="#">Terms of Service</a>
                        and
                        <a class="text-indigo-600 hover:text-indigo-600" href="#">Privacy Policy.</a>
                    </span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('accept')" />
        </div>

        <div class="grid">
            <x-primary-button>{{ __('Create Free Account') }}</x-primary-button>
        </div>

        <div class="mt-4 flex justify-between">
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
