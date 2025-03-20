<?php

namespace App\Http\Controllers;

use App\Http\Requests\OurProcessRequest;
use App\Models\OurProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OurProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('our-process.viewAny');

        $ourProcesses = OurProcess::select(['id', 'name', 'description', 'is_active'])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.our-processes.index', compact('ourProcesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('our-process.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OurProcessRequest $request): JsonResponse
    {
        Gate::authorize('our-process.create');

        OurProcess::create($request->validated());

        toastr()->success(__(':name created successfully!', ['name' => __('Our Process')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OurProcess $ourProcess): void
    {
        Gate::authorize('our-process.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurProcess $ourProcess): JsonResponse
    {
        Gate::authorize('our-process.update');

        return response()->json([
            'success' => true,
            'ourProcess' => $ourProcess,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OurProcessRequest $request, OurProcess $ourProcess): JsonResponse
    {
        Gate::authorize('our-process.update');

        $ourProcess->update($request->validated());

        toastr()->success(__(':name updated successfully!', ['name' => __('Our Process')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurProcess $ourProcess): JsonResponse
    {
        Gate::authorize('our-process.delete');

        if ($ourProcess->services()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('You can not delete this :name because it has :associate associated with it.', ['name' => 'Our Process', 'associate' => 'Services']),
            ]);
        }

        $ourProcess->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Our Process')]),
        ]);
    }

    public function status(Request $request, OurProcess $ourProcess): JsonResponse
    {
        Gate::authorize('our-process.update');

        $ourProcess->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
        ]);
    }
}
