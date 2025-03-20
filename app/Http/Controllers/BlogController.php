<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\MediaUploadService;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(private MediaUploadService $mediaUploadService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('blog.viewAny');

        $blogs = Blog::select(['id', 'title', 'reading_time', 'status', 'blog_category_id', 'created_by'])
            ->with([
                'category:id,name',
                'createdBy:id,name',
                'createdBy.avatar:id,path,mediable_type,mediable_id'
            ])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('blog.create');

        $blogCategories = BlogCategory::select(['id', 'name'])->get();

        return view('backend.blogs.create', compact('blogCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request): JsonResponse
    {
        Gate::authorize('blog.create');

        DB::transaction(function () use($request) {
            $blog = Blog::create(Arr::except($request->validated(), ['banner', 'feature_image']));

            if ($request->hasFile('banner')) {
                $this->mediaUploadService->uploadSingle($request->file('banner'), $blog, 'blogs', 'banner');
            }

            if ($request->hasFile('feature_image')) {
                $this->mediaUploadService->uploadSingle($request->file('feature_image'), $blog, 'blogs', 'featureImage');
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Blog saved successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        Gate::authorize('blog.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog): View
    {
        Gate::authorize('blog.update');

        $blog->load(
            'category:id,name',
            'banner:id,path,mediable_type,mediable_id',
            'featureImage:id,path,mediable_type,mediable_id',
        );

        if ($blog->banner) {
            $blog->banner->path = Storage::url($blog->banner->path);
        }

        if ($blog->featureImage) {
            $blog->featureImage->path = Storage::url($blog->featureImage->path);
        }

        $blogCategories = BlogCategory::select(['id', 'name'])->get();

        return view('backend.blogs.edit', compact(['blog', 'blogCategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        Gate::authorize('blog.update');

        $blog->load(
            'banner:id,path,mediable_type,mediable_id',
            'featureImage:id,path,mediable_type,mediable_id',
        );

        DB::transaction(function () use($request, $blog) {
            $blog->update($request->validated());

            if ($request->hasFile('banner')) {

                if ($blog->banner) {
                    $this->mediaUploadService->deleteMedia($blog->banner);
                }

                $this->mediaUploadService->uploadSingle($request->file('banner'), $blog, 'blogs', 'banner');
            }

            if ($request->hasFile('feature_image')) {

                if ($blog->featureImage) {
                    $this->mediaUploadService->deleteMedia($blog->featureImage);
                }

                $this->mediaUploadService->uploadSingle($request->file('feature_image'), $blog, 'blogs', 'featureImage');
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Blog updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): JsonResponse
    {
        Gate::authorize('blog.delete');

        $blog->load(
            'banner:id,path,mediable_type,mediable_id',
            'featureImage:id,path,mediable_type,mediable_id',
        );

        if ($blog->banner) {
            $this->mediaUploadService->deleteMedia($blog->banner);
        }

        if ($blog->featureImage) {
            $this->mediaUploadService->deleteMedia($blog->featureImage);
        }

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Blog')]),
        ]);
    }
}
