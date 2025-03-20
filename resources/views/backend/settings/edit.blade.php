<x-backend-layout>
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">
            {{ __('Settings') }}
        </h1>
    </x-slot>

    <div>
        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-lg-0 col-span-1">
                <h4 class="mb-1">{{ __('App Configuration') }}</h4>
                <p class="text-gray-600">{{ __('Update your application configuration settings.') }}</p>
            </div>
            <div class="card col-span-3 shadow">
                @include('backend.settings.partials.update-app-configuration-form', [
                    'settings' => $settings,
                    'languages' => $languages,
                    'timezones' => $timezones,
                ])
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-lg-0 col-span-1">
                <h4 class="mb-1">{{ __('General Settings') }}</h4>
                <p class="text-gray-600">
                    {{ __('Update your general settings.') }}</p>
            </div>
            <div class="card col-span-3 shadow">
                @include('backend.settings.partials.update-common-configuration-form', [
                    'settings' => $settings,
                ])
            </div>
        </div>
    </div>
</x-backend-layout>
