<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('faq_category.viewAny');

        $faqCategories = FaqCategory::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.faq-categories.index', compact('faqCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('faq_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('faq_category.create');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:16', 'unique:faq_categories,name'],
            'is_active' => ['boolean'],
        ]);

        FaqCategory::create($validatedData);

        toastr()->success(__(':name created successfully!', ['name' => __('Faq Category')]));

        return Redirect::route('faq-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqCategory $faqCategory): JsonResponse
    {
        Gate::authorize('faq_category.view');

        return response()->json([
            'success' => true,
            'faqCategory' => $faqCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqCategory $faqCategory)
    {
        Gate::authorize('faq_category.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqCategory $faqCategory): RedirectResponse
    {
        Gate::authorize('faq_category.update');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:16', 'unique:faq_categories,name,'.$faqCategory->id],
            'is_active' => ['boolean'],
        ]);

        $faqCategory->update($validatedData);

        toastr()->success(__(':name updated successfully!', ['name' => __('Faq Category')]));

        return Redirect::route('faq-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faqCategory)
    {
        Gate::authorize('faq_category.delete');

        if ($faqCategory->faqs()->exists()) {
            return response()->json([
                'status' => false,
                'message' => __(':name cannot be deleted because it has :records.', ['name' => __('Faq Category'), 'records' => __('faqs')]),
            ]);
        }

        $faqCategory->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Faq Category')]),
        ]);
    }

    public function statusUpdate(Request $request, FaqCategory $faqCategory): JsonResponse
    {
        Gate::authorize('faq_category.update');

        $faqCategory->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'status' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }
}
