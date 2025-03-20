<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbilitySupportRequest;
use App\Models\AbilitySupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AbilitySupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('ability-support.viewAny');

        $abilitySupports = AbilitySupport::select(['id', 'name', 'description', 'is_active'])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.ability-supports.index', compact('abilitySupports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('ability-support.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AbilitySupportRequest $request): JsonResponse
    {
        Gate::authorize('ability-support.create');

        AbilitySupport::create($request->validated());

        toastr()->success(__(':name created successfully!', ['name' => __('Ability Support')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AbilitySupport $abilitySupport): void
    {
        Gate::authorize('ability-support.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbilitySupport $abilitySupport): JsonResponse
    {
        Gate::authorize('ability-support.update');

        return response()->json([
            'success' => true,
            'abilitySupport' => $abilitySupport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AbilitySupportRequest $request, AbilitySupport $abilitySupport): JsonResponse
    {
        Gate::authorize('ability-support.update');

        $abilitySupport->update($request->validated());

        toastr()->success(__(':name updated successfully!', ['name' => __('Ability Support')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbilitySupport $abilitySupport): JsonResponse
    {
        Gate::authorize('ability-support.delete');

        if ($abilitySupport->services()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('You can not delete this :name because it has :associate associated with it.', ['name' => 'Ability Support', 'associate' => 'Services']),
            ]);
        }

        $abilitySupport->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Ability Support')]),
        ]);
    }

    public function status(Request $request, AbilitySupport $abilitySupport): JsonResponse
    {
        Gate::authorize('ability-support.update');

        $abilitySupport->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
        ]);
    }
}
