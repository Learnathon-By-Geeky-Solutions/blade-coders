<section>
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('Mail Configuration') }}</h4>
        </div>

        <form method="post" action="{{ route('settings.store') }}">
            @csrf

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="mail_default" :value="__('Mail Protocol')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <select
                            class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                            id="mail_default" name="mail_default" required>
                            @foreach ($mailers as $key => $mailer)
                                <option value="{{ $key }}" @selected(old('mail_default', $settings['mail_default']) === $key)>{{ $mailer }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('mail_default')" />
                </div>
            </div>

            <div id="smtp">
                <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                    <div class="flex-1 font-semibold text-gray-800">
                        <h5 class="mb-0">
                            <x-input-label for="mail_mailers_smtp_host" :value="__('SMTP Host')" />
                        </h5>
                    </div>
                    <div class="flex-[3]">
                        <div class="flex items-center">
                            <x-text-input id="mail_mailers_smtp_host" name="mail_mailers_smtp_host" type="text"
                                :value="old('mail_mailers_smtp_host', $settings['mail_mailers_smtp_host'])" autofocus />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('mail_mailers_smtp_host')" />
                    </div>
                </div>

                <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                    <div class="flex-1 font-semibold text-gray-800">
                        <h5 class="mb-0">
                            <x-input-label for="mail_mailers_smtp_port" :value="__('SMTP Port')" />
                        </h5>
                    </div>
                    <div class="flex-[3]">
                        <div class="flex items-center">
                            <x-text-input id="mail_mailers_smtp_port" name="mail_mailers_smtp_port" type="text"
                                :value="old('mail_mailers_smtp_port', $settings['mail_mailers_smtp_port'])" autofocus />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('mail_mailers_smtp_port')" />
                    </div>
                </div>

                <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                    <div class="flex-1 font-semibold text-gray-800">
                        <h5 class="mb-0">
                            <x-input-label for="mail_mailers_smtp_username" :value="__('SMTP Username')" />
                        </h5>
                    </div>
                    <div class="flex-[3]">
                        <div class="flex items-center">
                            <x-text-input id="mail_mailers_smtp_username" name="mail_mailers_smtp_username"
                                type="text" :value="old('mail_mailers_smtp_username', $settings['mail_mailers_smtp_username'])" autofocus />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('mail_mailers_smtp_username')" />
                    </div>
                </div>

                <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                    <div class="flex-1 font-semibold text-gray-800">
                        <h5 class="mb-0">
                            <x-input-label for="mail_mailers_smtp_password" :value="__('SMTP Password')" />
                        </h5>
                    </div>
                    <div class="flex-[3]">
                        <div class="flex items-center">
                            <x-text-input id="mail_mailers_smtp_password" name="mail_mailers_smtp_password"
                                type="text" :value="old('mail_mailers_smtp_password', $settings['mail_mailers_smtp_password'])" autofocus />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('mail_mailers_smtp_password')" />
                    </div>
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="mail_from_address" :value="__('Email Sent From Address')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="mail_from_address" name="mail_from_address" type="text" :value="old('mail_from_address', $settings['mail_from_address'])"
                            autofocus />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('mail_from_address')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="mail_from_name" :value="__('Email Sent From Name')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="mail_from_name" name="mail_from_name" type="text" :value="old('mail_from_name', $settings['mail_from_name'])"
                            autofocus />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('mail_from_name')" />
                </div>
            </div>

            <div class="inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800"></div>
                <div class="flex flex-[3] items-center gap-4">
                    <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                    <x-secondary-button id="sendTestMail" type="button">{{ __('Send Test Mail') }}</x-secondary-button>
                </div>
            </div>
        </form>
    </div>
</section>
