<x-guest-layout>
     <!-- Session Status -->
     <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- username -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" :value="old('password')" required autofocus autocomplete="password" placeholder="Enter Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- checkbox -->
        <div class="lg:flex justify-between items-center mb-4">
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2" name="remember">
                    <span class="inline-block ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>
        </div>
        <div>
            <!-- button -->
            <div class="grid">
                <x-primary-button>{{ __('Log in') }}</x-primary-button>
            </div>

            <div class="flex justify-between mt-4">
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
