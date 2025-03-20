<?php

namespace App\Http\Controllers;

use App\Enums\ResourceType;
use App\Http\Requests\ResourceRequest;
use App\Models\Resource;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function __construct(private MediaUploadService $mediaUploadService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        Gate::authorize('resource.viewAny');

        $resources = Resource::with('file:id,path,mediable_type,mediable_id')->latest()->paginate(config('setting.pagination_limit'));

        return view('backend.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('resource.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceRequest $request): JsonResponse
    {
        Gate::authorize('resource.create');

        $resource = Resource::create($request->validated());

        if ($request->input('type') === ResourceType::FILE->value && $request->hasFile('file')) {
            $this->mediaUploadService->uploadSingle($request->file('file'), $resource, 'resources', 'file');
        }

        return response()->json([
            'success' => true,
            'message' => __(':name created successfully!', ['name' => __('Resource')])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource): JsonResponse
    {
        Gate::authorize('resource.view');

        if ($resource->type === ResourceType::FILE->value) {
            $resource->load('file:id,path,mediable_type,mediable_id');
            $resource->file->path = Storage::url($resource->file->path);
        }

        return response()->json([
            'success' => true,
            'message' => __(':name retrieved successfully!', ['name' => __('Resource')]),
            'resource' => $resource
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        Gate::authorize('resource.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResourceRequest $request, Resource $resource): JsonResponse
    {
        Gate::authorize('resource.update');

        $resource->load('file');

        if ($request->input('type') !== $resource->type) {
            $resource = $this->handleTypeCahange($request->input('type'), $resource);
        }

        if ($request->input('type') === ResourceType::FILE->value && $request->hasFile('file')) {
            if ($resource->file) {
                $this->mediaUploadService->deleteMedia($resource->file);
            }

            $this->mediaUploadService->uploadSingle($request->file('file'), $resource, 'resources', 'file');
        }

        $resource->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => __(':name updated successfully!', ['name' => __('Resource')]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        Gate::authorize('resource.delete');

        $resource->load('file');

        if ($resource->type === ResourceType::FILE->value && $resource->file) {
            $this->mediaUploadService->deleteMedia($resource->file);
        }

        $resource->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Resource')]),
        ]);
    }

    public function statusUpdate(Request $request, Resource $resource): JsonResponse
    {
        Gate::authorize('resource.update');

        $resource->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }

    private function handleTypeCahange(string $type, Resource $resource): Resource
    {
        if ($type === ResourceType::FILE->value) {
            $resource->link = null;
        } elseif ($type === ResourceType::LINK->value) {
            $this->mediaUploadService->deleteMedia($resource->file);
        }

        return $resource;
    }
}
