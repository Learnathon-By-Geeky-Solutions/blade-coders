<section>
    <div class="card-body">
        <div class="mb-6">
            <h4 class="mb-1">{{ __('General Settings') }}</h4>
        </div>

        <form class="mt-6 space-y-6" method="post" action="{{ route('settings.store') }}">
            @csrf

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800">
                    <h5 class="mb-0">
                        <x-input-label for="pagination_limit" :value="__('Pagination Limit')" />
                    </h5>
                </div>
                <div class="flex-[3]">
                    <div class="flex items-center">
                        <x-text-input id="pagination_limit" name="pagination_limit" type="number" :value="old('pagination_limit', $settings['pagination_limit'])" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('pagination')" />
                </div>
            </div>

            <div class="mb-6 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                <div class="flex-1 font-semibold text-gray-800"></div>
                <div class="flex flex-[3] items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</section>
