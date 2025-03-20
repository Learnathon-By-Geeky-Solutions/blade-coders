<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('faq.viewAny');

        $faqs = Faq::with('category:id,name')->latest()->paginate(config('setting.pagination_limit'));

        $categories = FaqCategory::select(['id', 'name'])->get();

        return view('backend.faqs.index', compact(['faqs', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('faq.create');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string',],
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'is_active' => ['boolean'],
        ]);

        Faq::create($validatedData);

        toastr()->success(__(':name created successfully!', ['name' => __('FAQ')]));

        return Redirect::route('faqs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        Gate::authorize('faq.view');

        return response()->json([
            'success' => true,
            'faq' => $faq->load('category:id,name'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        Gate::authorize('faq.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        Gate::authorize('faq.update');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'is_active' => ['boolean'],
        ]);

        $faq->update($validatedData);

        toastr()->success(__(':name updated successfully!', ['name' => __('Faq')]));

        return Redirect::route('faqs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        Gate::authorize('faq.delete');

        $faq->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Faq')]),
        ]);
    }

    public function statusUpdate(Request $request, Faq $faq): JsonResponse
    {
        Gate::authorize('faq.update');

        $faq->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'status' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }
}
