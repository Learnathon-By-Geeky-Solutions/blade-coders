<section>
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('App Configuration') }}</h4>
        </div>

        <form method="post" action="{{ route('settings.store') }}">
            @csrf

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="app_name" :value="__('App Name')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="app_name" name="app_name" type="text" :value="old('app_name', $settings['app_name'])" autofocus />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('app_name')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="app_locale" :value="__('App Locale')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <select
                            class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                            id="app_locale" name="app_locale" required>
                            {{-- <option value="" selected disabled>{{ __('Select User Role') }}</option> --}}
                            @foreach ($languages as $key => $language)
                                <option value="{{ $key }}" @selected(old('app_locale', $settings['app_locale']) === $key)>{{ $language }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('app_locale')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="app_timezone" :value="__('App Timezone')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <select
                            class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                            id="app_timezone" name="app_timezone" required>
                            {{-- <option value="" selected disabled>{{ __('Select User Role') }}</option> --}}
                            @foreach ($timezones as $key => $timezone)
                                <option value="{{ $key }}" @selected(old('app_timezone', $settings['app_timezone']) === $key)>{{ $timezone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('app_timezone')" />
                </div>
            </div>

            <div class="inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800"></div>
                <div class="flex flex-[3] items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</section>
