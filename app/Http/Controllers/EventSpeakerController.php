<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSpeakerRequest;
use App\Models\EventSpeaker;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EventSpeakerController extends Controller
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
        Gate::authorize('event-speaker.viewAny');

        $eventSpeakers = EventSpeaker::with('profilePicture')->select(['id', 'name', 'designation', 'about', 'is_active'])
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        return view('backend.event-speakers.index', compact('eventSpeakers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('event-speaker.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventSpeakerRequest $request): JsonResponse
    {
        Gate::authorize('event-speaker.create');

        $eventSpeaker = EventSpeaker::create($request->validated());

        if ($request->has('profile_picture')) {
            if ($eventSpeaker->profile_picture) {
                $this->mediaUploadService->deleteMedia($eventSpeaker->profile_picture);
            }

            $this->mediaUploadService->uploadSingle($request->file('profile_picture'), $eventSpeaker, 'profile_pictures', 'profilePicture');
        }

        toastr()->success(__(':name created successfully!', ['name' => __('Event Speaker')]));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventSpeaker $eventSpeaker): void
    {
        Gate::authorize('event-speaker.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventSpeaker $eventSpeaker): JsonResponse
    {
        Gate::authorize('event-speaker.update');

        return response()->json([
            'success' => true,
            'eventSpeaker' => $eventSpeaker->load('profilePicture'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventSpeakerRequest $request, EventSpeaker $eventSpeaker): JsonResponse
    {
        Gate::authorize('event-speaker.update');

        $eventSpeaker->update($request->validated());

        if ($request->has('profile_picture')) {
            if ($eventSpeaker->profilePicture) {
                $this->mediaUploadService->deleteMedia($eventSpeaker->profilePicture);
            }

            $this->mediaUploadService->uploadSingle($request->file('profile_picture'), $eventSpeaker, 'profile_pictures', 'profilePicture');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Event Speaker')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventSpeaker $eventSpeaker): JsonResponse
    {
        Gate::authorize('event-speaker.delete');

        if ($eventSpeaker->events()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('You can not delete this :name because it has :associate associated with it.', ['name' => 'Event Speaker', 'associate' => 'Events']),
            ]);
        }

        $eventSpeaker->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Event Speaker')]),
        ]);
    }

    public function status(Request $request, EventSpeaker $eventSpeaker): JsonResponse
    {
        Gate::authorize('event-speaker.update');

        $eventSpeaker->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json(['success' => true]);
    }
}
