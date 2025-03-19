<?php

namespace App\Http\Controllers;

use App\Http\Requests\BenefitRequest;
use App\Models\Benefit;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BenefitController extends Controller
{
    public function __construct(
        private readonly MediaUploadService $mediaUploadService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('benefit.viewAny');

        $benefits = Benefit::select(['id', 'name', 'description', 'is_active'])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.benefits.index', compact('benefits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('benefit.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BenefitRequest $request): JsonResponse
    {
        Gate::authorize('benefit.create');

        $benefit = Benefit::create($request->validated());

        if ($request->has('icon')) {
            if ($benefit->icon) {
                $this->mediaUploadService->deleteMedia($benefit->icon);
            }

            $this->mediaUploadService->uploadSingle($request->file('icon'), $benefit, 'icons', 'icon');
        }

        toastr()->success(__(':name created successfully!', ['name' => __('Benefit')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Benefit $benefit): void
    {
        Gate::authorize('benefit.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Benefit $benefit): JsonResponse
    {
        Gate::authorize('benefit.update');

        return response()->json([
            'success' => true,
            'benefit' => $benefit->load('icon'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BenefitRequest $request, Benefit $benefit): JsonResponse
    {
        Gate::authorize('benefit.update');

        $benefit->update($request->validated());

        if ($request->has('icon')) {
            if ($benefit->icon) {
                $this->mediaUploadService->deleteMedia($benefit->icon);
            }

            $this->mediaUploadService->uploadSingle($request->file('icon'), $benefit, 'icons', 'icon');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Benefit')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Benefit $benefit): JsonResponse
    {
        Gate::authorize('benefit.delete');

        if ($benefit->services()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('You can not delete this :name because it has :associate associated with it.', ['name' => 'Benefit', 'associate' => 'Services']),
            ]);
        }

        $benefit->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Benefit')]),
        ]);
    }

    public function status(Request $request, Benefit $benefit): JsonResponse
    {
        Gate::authorize('benefit.update');

        $benefit->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
        ]);
    }
}
