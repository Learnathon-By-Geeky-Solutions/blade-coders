<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3 grid">
            <x-primary-button>{{ __('Reset Password') }}</x-primary-button>
        </div>

        @if (Route::has('register'))
            <span>
                {{ __("Don't have an account?") }}
                <a class="text-indigo-600 hover:text-indigo-600" href="{{ route('register') }}">
                    {{ __('Create An Account') }}
                </a>
            </span>
        @endif
    </form>
</x-guest-layout>
