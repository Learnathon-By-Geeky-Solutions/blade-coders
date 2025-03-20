<x-guest-layout :title="__('Login')">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- username -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                autocomplete="username" placeholder="Enter Email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <!-- password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" :value="old('password')" required autofocus
                autocomplete="password" placeholder="Enter Password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>
        <!-- checkbox -->
        <div class="mb-4 items-center justify-between lg:flex">
            <div class="flex items-center">
                <label class="inline-flex items-center" for="remember_me">
                    <input
                        class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="remember_me" name="remember" type="checkbox">
                    <span class="ms-2 inline-block">{{ __('Remember me') }}</span>
                </label>
            </div>
        </div>
        <div>
            <!-- button -->
            <div class="grid">
                <x-primary-button>{{ __('Log in') }}</x-primary-button>
            </div>

            <div class="mt-4 flex justify-between">
                @if (Route::has('register'))
                    <div class="mb-2">
                        <a class="text-indigo-600 hover:text-indigo-600" href="{{ route('register') }}">
                            {{ __('Create An Account') }}
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
        </div>
    </form>
</x-guest-layout>
