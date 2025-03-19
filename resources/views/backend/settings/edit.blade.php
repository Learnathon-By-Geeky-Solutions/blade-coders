<x-backend-layout :title="__('Settings')">
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
                <h4 class="mb-1">{{ __('Mail Configuration') }}</h4>
                <p class="text-gray-600">{{ __('Update your mail configuration settings.') }}</p>
            </div>
            <div class="card col-span-3 shadow">
                @include('backend.settings.partials.update-mail-configuration-form', [
                    'settings' => $settings,
                    'mailers' => $mailers,
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
                    'roles' => $roles,
                ])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                const mail_default = $('#mail_default');

                mail_default.change(function() {
                    const selected = $(this).find(":selected").text().trim();

                    if (selected === 'SMTP') {
                        $('#smtp').show();
                    } else {
                        $('#smtp').hide();
                    }
                });

                mail_default.change();

                $('#sendTestMail').click(function() {
                    Swal.fire({
                        text: "Enter Your Email Address",
                        input: "text",
                        inputAttributes: {
                            autocapitalize: "off"
                        },
                        showCancelButton: true,
                        confirmButtonText: "Send",
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        preConfirm: async (email) => {
                            try {
                                const url = route('settings.send-test-mail');
                                const response = await fetch(url, {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        'Accept': "application/json",
                                        "Content-Type": "application/json",
                                    },
                                    method: "POST",
                                    body: JSON.stringify({
                                        email: email
                                    })
                                });
                                if (!response.ok) {
                                    const data = await response.json();
                                    return Swal.showValidationMessage(data.message);
                                }
                                return response.json();
                            } catch (error) {
                                Swal.showValidationMessage(`Request failed: ${error}`);
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log(result.value.message)
                            Swal.fire({
                                title: 'Success!',
                                text: result.value.message,
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
</x-backend-layout>
