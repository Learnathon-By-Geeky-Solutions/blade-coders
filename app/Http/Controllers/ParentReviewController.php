<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentReviewRequest;
use App\Models\ParentReview;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ParentReviewController extends Controller
{
    public function __construct(private MediaUploadService $mediaUploadService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('parent_review.viewAny');

        $parentReviews = ParentReview::with('parentAvatar:id,path,mediable_type,mediable_id')->latest()->paginate(config('setting.pagination_limit'));

        return view('backend.parent-reviews.index', compact('parentReviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('parent_review.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParentReviewRequest $request): RedirectResponse
    {
        Gate::authorize('parent_review.create');

        $parentReview = ParentReview::create($request->validated());

        if ($request->hasFile('parent_avatar')) {
            $this->mediaUploadService->uploadSingle($request->file('parent_avatar'), $parentReview, 'parent-review/parent-avatar', 'parentAvatar');
        }

        toastr()->success('Parent review created successfully.');

        return Redirect::route('parent-reviews.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentReview $parentReview): JsonResponse
    {
        Gate::authorize('parent_review.delete');

        $parentReview->load('parentAvatar:id,path,mediable_type,mediable_id');

        if ($parentReview->parentAvatar) {
            $parentReview->parentAvatar->path = Storage::url($parentReview->parentAvatar->path);
        }

        return response()->json([
            'success' => true,
            'parentReview' => $parentReview,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentReview $parentReview)
    {
        Gate::authorize('parent_review.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParentReviewRequest $request, ParentReview $parentReview): RedirectResponse
    {
        Gate::authorize('parent_review.update');

        $parentReview->load('parentAvatar:id,path,mediable_type,mediable_id');

        $parentReview->update($request->validated());

        if ($request->hasFile('parent_avatar')) {
            if ($parentReview->parentAvatar) {
                $this->mediaUploadService->deleteMedia($parentReview->parentAvatar);
            }

            $this->mediaUploadService->uploadSingle($request->file('parent_avatar'), $parentReview, 'parent-review/parent-avatar', 'parentAvatar');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Parent Review')]));

        return Redirect::route('parent-reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentReview $parentReview): JsonResponse
    {
        Gate::authorize('parent_review.delete');

        $parentReview->load('parentAvatar');

        if ($parentReview->parentAvatar) {
            $this->mediaUploadService->deleteMedia($parentReview->parentAvatar);
        }

        $parentReview->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Parent Review')]),
        ]);
    }

    public function statusUpdate(Request $request, ParentReview $parentReview): JsonResponse
    {
        Gate::authorize('parent_review.update');

        $parentReview->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'status' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }
}
