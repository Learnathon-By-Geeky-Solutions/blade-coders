<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTypeRequest;
use App\Models\EventType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('event-type.viewAny');

        $eventTypes = EventType::select(['id', 'name', 'is_active'])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.event-types.index', compact('eventTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('event-type.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventTypeRequest $request): JsonResponse
    {
        Gate::authorize('event-type.create');

        EventType::create($request->validated());

        toastr()->success(__(':name created successfully!', ['name' => __('Event Type')]));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType): void
    {
        Gate::authorize('event-type.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventType $eventType): JsonResponse
    {
        Gate::authorize('event-type.update');

        return response()->json([
            'success' => true,
            'eventType' => $eventType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventTypeRequest $request, EventType $eventType): JsonResponse
    {
        Gate::authorize('event-type.update');

        $eventType->update($request->validated());

        toastr()->success(__(':name updated successfully!', ['name' => __('Event Type')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType): JsonResponse
    {
        Gate::authorize('event-type.delete');

        if ($eventType->events()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('You can not delete this :name because it has :associate associated with it.', ['name' => 'Event Type', 'associate' => 'Events']),
            ]);
        }

        $eventType->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Event Type')]),
        ]);
    }

    public function status(Request $request, EventType $eventType): JsonResponse
    {
        Gate::authorize('event-type.update');

        $eventType->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json(['success' => true]);
    }
}
