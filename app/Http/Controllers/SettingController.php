<?php

namespace App\Http\Controllers;

use AmdadulHaq\Setting\Models\Setting;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function index(): View
    {
        Gate::authorize('setting.view');

        $settings = [
            'app_name' => config('app.name'),
            'app_locale' => config('app.locale'),
            'app_timezone' => config('app.timezone'),
            'pagination_limit' => config('setting.pagination_limit'),
        ];

        $languages = Language::active()->pluck('name', 'locale')->toArray();
        $timezones = config('timezones');

        return view('backend.settings.edit', compact('settings', 'languages', 'timezones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(UpdateSettingRequest $request): RedirectResponse
    {
        Gate::authorize('setting.update');

        foreach ($request->validated() as $key => $value) {
            Setting::set($key, $value);
        }

        toastr()->success('Updated Settings Successfully');

        return Redirect::back();
    }
}
