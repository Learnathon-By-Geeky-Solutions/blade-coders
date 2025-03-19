<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('language.viewAny');

        $languages = Language::latest()->paginate(config('setting.pagination_limit', 10));

        return view('backend.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('language.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(LanguageRequest $request): JsonResponse
    {
        Gate::authorize('language.create');

        $locale = $request->input('locale');
        $baseLocale = config('setting.default_locale', 'en');
        $baseFile = lang_path("$baseLocale.json");
        $newFile = lang_path("$locale.json");

        if (! File::exists($newFile)) {
            $baseTranslations = File::json($baseFile);

            File::put($newFile, json_encode($baseTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        Language::create($request->validated());

        toastr()->success(__(':name created successfully!', ['name' => __('Language')]));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language): void
    {
        Gate::authorize('language.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language): JsonResponse
    {
        Gate::authorize('language.update');

        return response()->json([
            'success' => true,
            'language' => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, Language $language): JsonResponse
    {
        Gate::authorize('language.update');

        $language->update($request->validated());

        toastr()->success(__(':name updated successfully!', ['name' => __('Language')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language): JsonResponse
    {
        Gate::authorize('language.delete');

        $language->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Language')]),
        ]);
    }

    public function status(Request $request, Language $language): JsonResponse
    {
        Gate::authorize('language.update');

        if ($language->locale === config('app.locale') && ! $request->boolean('status')) {
            toastr()->error(__("Default :name can't inactivated.", ['name' => __('Language')]));

            return response()->json(['success' => false]);
        }

        $language->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json(['success' => true]);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function translation(Language $language): View
    {
        Gate::authorize('language.update');

        $filePath = lang_path("$language->locale.json");

        if (! File::exists($filePath)) {
            return Redirect::back()->withError(__('Language file (:locale.json) not found.', ['locale' => $language->locale]));
        }

        $translations = File::json($filePath);

        return view('backend.languages.translation', compact('language', 'translations'));
    }

    public function translationUpdate(Request $request, Language $language): RedirectResponse
    {
        $data = $request->validate([
            'translations' => 'required|array',
            'translations.*.key' => 'required|string',
            'translations.*.value' => 'required|string',
        ]);

        $filePath = lang_path("{$language->locale}.json");

        if (! File::exists($filePath)) {
            toastr()->error(__('Language file (:locale.json) not found.', ['locale' => $language->locale]));

            return Redirect::back();
        }

        $updatedTranslations = [];

        foreach ($data['translations'] as $translation) {
            $updatedTranslations[$translation['key']] = $translation['value'];
        }

        File::put($filePath, json_encode($updatedTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        toastr()->success(__('Languages for :locale updated successfully.', ['locale' => $language->locale]));

        return Redirect::back();
    }
}
