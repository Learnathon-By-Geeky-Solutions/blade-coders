<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\AbilitySupport;
use App\Models\Benefit;
use App\Models\OurProcess;
use App\Models\Service;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ServiceController extends Controller
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
        Gate::authorize('service.viewAny');

        $services = Service::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('service.create');

        $benefits = Benefit::active()->pluck('name', 'id')->toArray();
        $abilitySupports = AbilitySupport::active()->pluck('name', 'id')->toArray();
        $ourProcesses = OurProcess::active()->pluck('name', 'id')->toArray();

        return view('backend.services.form', compact('benefits', 'abilitySupports', 'ourProcesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        Gate::authorize('service.create');

        $service = Service::create(Arr::except($request->validated(), ['icon', 'background_image', 'ability_support_image', 'benefits', 'ability_supports', 'our_processes']));

        $service->benefits()->sync($request->benefits);
        $service->abilitySupports()->sync($request->ability_supports);
        $service->ourProcesses()->sync($request->our_processes);

        if ($request->has('icon')) {
            $this->mediaUploadService->uploadSingle($request->file('icon'), $service, 'services/icons', 'icon');
        }

        if ($request->has('background_image')) {
            $this->mediaUploadService->uploadSingle($request->file('background_image'), $service, 'services/background_images', 'backgroundImage');
        }

        if ($request->has('ability_support_image')) {
            $this->mediaUploadService->uploadSingle($request->file('ability_support_image'), $service, 'services/ability_support_images', 'abilitySupportImage');
        }

        toastr()->success(__(':name created successfully!', ['name' => __('Service')]));

        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): void
    {
        Gate::authorize('service.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        Gate::authorize('service.update');

        $benefits = Benefit::active()->pluck('name', 'id')->toArray();
        $abilitySupports = AbilitySupport::active()->pluck('name', 'id')->toArray();
        $ourProcesses = OurProcess::active()->pluck('name', 'id')->toArray();

        return view('backend.services.form', compact('service', 'benefits', 'abilitySupports', 'ourProcesses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        Gate::authorize('service.update');

        $service->update(Arr::except($request->validated(), ['icon', 'background_image', 'ability_support_image', 'benefits', 'ability_supports', 'our_processes']));

        $service->benefits()->sync($request->benefits);
        $service->abilitySupports()->sync($request->ability_supports);
        $service->ourProcesses()->sync($request->our_processes);

        if ($request->has('icon')) {
            if ($service->icon) {
                $this->mediaUploadService->deleteMedia($service->icon);
            }

            $this->mediaUploadService->uploadSingle($request->file('icon'), $service, 'services/icons', 'icon');
        }

        if ($request->has('background_image')) {
            if ($service->backgroundImage) {
                $this->mediaUploadService->deleteMedia($service->backgroundImage);
            }

            $this->mediaUploadService->uploadSingle($request->file('background_image'), $service, 'services/background_images', 'backgroundImage');
        }

        if ($request->has('ability_support_image')) {
            if ($service->abilitySupportImage) {
                $this->mediaUploadService->deleteMedia($service->abilitySupportImage);
            }

            $this->mediaUploadService->uploadSingle($request->file('ability_support_image'), $service, 'services/ability_support_images', 'abilitySupportImage');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Service')]));

        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        Gate::authorize('service.delete');

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Service')]),
        ]);
    }
}
