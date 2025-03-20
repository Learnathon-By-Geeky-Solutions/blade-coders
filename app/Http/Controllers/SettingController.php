<?php

namespace App\Http\Controllers;

use AmdadulHaq\Guard\Models\Role;
use App\Http\Requests\UpdateSettingRequest;
use App\Mail\TestMail;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
            'website_logo' => config('setting.website_logo'),
            'website_favicon' => config('setting.website_favicon'),
            'mail_default' => config('mail.default'),
            'mail_mailers_smtp_host' => config('mail.mailers.smtp.host'),
            'mail_mailers_smtp_port' => config('mail.mailers.smtp.port'),
            'mail_mailers_smtp_username' => config('mail.mailers.smtp.username'),
            'mail_mailers_smtp_password' => config('mail.mailers.smtp.password'),
            'mail_from_name' => config('mail.from.name'),
            'mail_from_address' => config('mail.from.address'),
            'email_verification' => config('setting.email_verification'),
            'default_role' => config('setting.default_role'),
            'pagination_limit' => config('setting.pagination_limit'),
        ];

        $languages = Language::active()->pluck('name', 'locale')->toArray();
        $timezones = config('timezones');

        $mailers = ['smtp' => 'SMTP', 'sendmail' => 'Send Mail'];

        $roles = Role::get();

        return view('backend.settings.edit', compact('settings', 'languages', 'timezones', 'mailers', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(UpdateSettingRequest $request): RedirectResponse
    {
        Gate::authorize('setting.update');

        $data = $request->validated();

        $this->handleFileUpload($request, 'website_logo', $data);
        $this->handleFileUpload($request, 'website_favicon', $data);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        toastr()->success('Updated Settings Successfully');

        return Redirect::back();
    }

    public function sendTestMail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        Mail::to($request->input('email'))->send(new TestMail);

        return response()->json([
            'success' => true,
            'message' => 'Test Mail Send Successfully',
        ]);
    }

    private function handleFileUpload($request, $fileKey, &$data): void
    {
        if ($request->hasFile($fileKey)) {
            $existingFile = Setting::get($fileKey);

            if ($existingFile) {
                $storage = Storage::disk('public');
                if ($storage->exists($existingFile)) {
                    $storage->delete($existingFile);
                }
            }

            $file = $request->file($fileKey);
            $data[$fileKey] = $file->store('setting', 'public');
        }
    }
}
