<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('blog_category.viewAny');

        $blogCategories = BlogCategory::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.blog-categories.index', compact('blogCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('blog_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        Gate::authorize('blog_category.create');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:16', 'unique:blog_categories,name'],
            'is_active' => ['boolean'],
        ]);

        BlogCategory::create($validatedData);

        toastr()->success(__(':name created successfully!', ['name' => __('Blog Category')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory): void
    {
        Gate::authorize('blog_category.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory): JsonResponse
    {
        Gate::authorize('blog_category.update');

        return response()->json([
            'success' => true,
            'blogCategory' => $blogCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory): JsonResponse
    {
        Gate::authorize('blog_category.update');

        $request->merge(['is_active' => $request->has('is_active')]);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:16', 'unique:blog_categories,name,'.$blogCategory->id],
            'is_active' => ['boolean'],
        ]);

        $blogCategory->update($validatedData);

        toastr()->success(__(':name updated successfully!', ['name' => __('Blog Category')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory): JsonResponse
    {
        Gate::authorize('blog_category.delete');

        if ($blogCategory->blogs()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __(':name cannot be deleted because it has :records.', ['name' => __('Blog Category'), 'records' => __('blogs')]),
            ], Response::HTTP_BAD_REQUEST);
        }

        $blogCategory->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Blog Category')]),
        ]);
    }

    public function statusUpdate(Request $request, BlogCategory $blogCategory): JsonResponse
    {
        Gate::authorize('blog_category.update');

        $blogCategory->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }
}
