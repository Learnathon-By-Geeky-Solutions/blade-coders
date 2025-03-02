<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('language.viewAny');

        $languages = Language::paginate(config('setting.pagination_limit', 10));

        return view('backend.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('language.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('language.create');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'locale' => ['required', 'string', 'min:2', 'max:2', 'unique:languages,locale'],
            'name' => ['required', 'string', 'unique:languages,name'],
            'is_active' => ['boolean'],
        ]);

        $locale = $request->input('locale');
        $baseLocale = config('setting.default_locale', 'en');
        $baseFile = lang_path("$baseLocale.json");
        $newFile = lang_path("$locale.json");

        if (! File::exists($newFile)) {
            $baseTranslations = File::json($baseFile);

            File::put($newFile, json_encode($baseTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        Language::create($validatedData);

        toastr()->success(__(':name created successfully!', ['name' => __('Language')]));

        return Redirect::route('languages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('language.view');
            abort(Response::HTTP_NOT_FOUND);
        }

        if (! auth()->user()->can('language.view')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'language' => $language,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        Gate::authorize('language.update');

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        Gate::authorize('language.update');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'locale' => ['required', 'string', 'min:2', 'max:2', 'unique:languages,locale,'.$language->id],
            'name' => ['required', 'string', 'unique:languages,name,'.$language->id],
            'is_active' => ['boolean'],
        ]);

        $language->update($validatedData);

        toastr()->success(__(':name updated successfully!', ['name' => __('Language')]));

        return Redirect::route('languages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('language.delete');
        }

        if (! auth()->user()->can('language.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $language->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Language')]),
        ]);
    }

    public function statusUpdate(Request $request, Language $language): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('language.update');
        }

        if (! auth()->user()->can('language.update')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $language->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'status' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
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
