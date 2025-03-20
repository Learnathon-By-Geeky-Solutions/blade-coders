<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div>
        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-lg-0 col-span-1">
                <h4 class="mb-1">{{ __('Profile Information') }}</h4>
                <p class="text-gray-600">{{ __("Update your account's profile information and email address.") }}</p>
            </div>
            <div class="card col-span-3 shadow">
                @include('backend.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-lg-0 col-span-1">
                <h4 class="mb-1">{{ __('Update Password') }}</h4>
                <p class="text-gray-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
            </div>
            <div class="card col-span-3 shadow">
                @include('backend.profile.partials.update-password-form')
            </div>
        </div>

        {{-- <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-lg-0 col-span-1">
            </div>
            <div class="card shadow col-span-3">
                @include('backend.profile.partials.delete-user-form')
            </div>
        </div> --}}
    </div>
</x-backend-layout>
