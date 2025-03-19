@if (config('setting.website_logo'))
    <img src="{{ Storage::url(config('setting.website_logo')) }}" alt="{{ config('app.name') }}" {{ $attributes }} />
@else
    <h2 class="-my-2 text-xl text-white">{{ config('app.name') }}</h2>
@endif
