<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private MediaUploadService $mediaUploadService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('page.viewAny');

        $pages = Page::select(['id', 'title', 'slug', 'subtitle', 'status'])->latest()->paginate(config('setting.pagination_limit'));

        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('page.create');

        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {
        Gate::authorize('page.create');

        $page = Page::create($request->validated());

        if ($request->hasFile('banner')) {
            $this->mediaUploadService->uploadSingle($request->file('banner'), $page, 'page', 'banner');
        }

        toastr()->success(__(':name created successfully!', ['name' => __('Custoom Page')]));

        return Redirect::route('pages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): View
    {
        Gate::authorize('page.update');

        $page->load('banner:id,path,mediable_type,mediable_id');

        if ($page->banner) {
            $page->banner->path = Storage::url($page->banner->path);
        }

        return view('backend.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        Gate::authorize('page.update');

        $page->update($request->validated());

        if ($request->hasFile('banner')) {

            $page->load('banner:id,path,mediable_type,mediable_id');

            if ($page->banner) {
                $this->mediaUploadService->deleteMedia($page->banner);
            }

            $this->mediaUploadService->uploadSingle($request->file('banner'), $page, 'page', 'banner');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Custom Page')]));

        return Redirect::route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): JsonResponse
    {
        Gate::authorize('page.delete');

        $page->load('banner');

        if ($page->banner) {
            $this->mediaUploadService->deleteMedia($page->banner);
        }

        $page->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Custom page')]),
        ]);
    }
}
