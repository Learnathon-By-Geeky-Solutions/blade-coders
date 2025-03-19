<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\EventType;
use App\Models\Service;
use App\Services\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EventController extends Controller
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
        Gate::authorize('event.viewAny');

        $events = Event::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('event.create');

        $services = Service::pluck('name', 'id')->toArray();
        $eventTypes = EventType::pluck('name', 'id')->toArray();
        $eventSpeakers = EventSpeaker::active()->pluck('name', 'id')->toArray();

        return view('backend.events.form', compact('services', 'eventTypes', 'eventSpeakers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request): JsonResponse
    {
        Gate::authorize('event.create');

        $event = Event::create(Arr::except($request->validated(), ['featured_image', 'background_image', 'event_speakers']));

        $event->eventSpeakers()->sync($request->event_speakers);

        if ($request->has('featured_image')) {
            $this->mediaUploadService->uploadSingle($request->file('featured_image'), $event, 'events/featured_images', 'featuredImage');
        }

        if ($request->has('background_image')) {
            $this->mediaUploadService->uploadSingle($request->file('background_image'), $event, 'events/background_images', 'backgroundImage');
        }

        toastr()->success(__(':name created successfully!', ['name' => __('Event')]));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): void
    {
        Gate::authorize('event.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        Gate::authorize('event.update');

        $services = Service::pluck('name', 'id')->toArray();
        $eventTypes = EventType::pluck('name', 'id')->toArray();
        $eventSpeakers = EventSpeaker::active()->pluck('name', 'id')->toArray();

        return view('backend.events.form', compact('event', 'services', 'eventTypes', 'eventSpeakers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event): JsonResponse
    {
        Gate::authorize('event.update');

        $event->update(Arr::except($request->validated(), ['featured_image', 'background_image', 'event_speakers']));

        $event->eventSpeakers()->sync($request->event_speakers);

        if ($request->has('featured_image')) {
            if ($event->featuredImage) {
                $this->mediaUploadService->deleteMedia($event->featuredImage);
            }

            $this->mediaUploadService->uploadSingle($request->file('featured_image'), $event, 'events/featured_images', 'featuredImage');
        }

        if ($request->has('background_image')) {
            if ($event->backgroundImage) {
                $this->mediaUploadService->deleteMedia($event->backgroundImage);
            }

            $this->mediaUploadService->uploadSingle($request->file('background_image'), $event, 'events/background_images', 'backgroundImage');
        }

        toastr()->success(__(':name updated successfully!', ['name' => __('Event')]));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): JsonResponse
    {
        Gate::authorize('event.delete');

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Event')]),
        ]);
    }
}
