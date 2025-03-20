@use('App\Enums\EventStatus')

<x-backend-layout :title="isset($event->id) ? __('Edit Event') : __('Create Event')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">
            {{ isset($event->id) ? __('Edit Event') : __('Create Event') }}</h1>
        <div>
            <x-secondary-button form="event_form" type="submit" onclick="save('{{ EventStatus::DRAFT }}')"
                icon="save">{{ __('Draft') }}</x-secondary-button>
            <x-primary-button form="event_form" type="submit" onclick="save('{{ EventStatus::PUBLISHED }}')"
                icon="send">{{ __('Publish') }}</x-primary-button>
        </div>
    </x-slot>

    <form id="event_form" method="POST"
        action="{{ isset($event) ? route('events.update', $event->id) : route('events.store') }}"
        enctype="multipart/form-data">
        @csrf
        @isset($event)
            @method('PUT')
        @endisset
        @isset($event)
            <input id="event_id" name="event_id" type="hidden" value="{{ $event->id }}">
        @endisset
        <input id="status" name="status" type="hidden">

        <div class="space-y-4">
            <x-card class="p-4">
                <h3>{{ __('Event Information') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="service_id" :value="__('Service')" />
                        <x-select id="service_id" name="service_id" required>
                            @foreach ($services as $key => $service)
                                <option value="{{ $key }}" @selected(old('service_id', isset($event) && $event->service_id))>{{ $service }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('our_speakers')" />
                    </div>

                    <div>
                        <x-input-label for="event_type_id" :value="__('Event Type')" />
                        <x-select id="event_type_id" name="event_type_id" required>
                            @foreach ($eventTypes as $key => $eventType)
                                <option value="{{ $key }}" @selected(old('event_type_id', isset($event) && $event->event_type_id))>{{ $eventType }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('our_speakers')" />
                    </div>

                    <div>
                        <x-input-label for="featured_image" :value="__('Featured Image')" />
                        <x-file-upload id="featured_image" name="featured_image" accept="image/*" :required="!isset($event)" />
                        <x-input-error class="mt-2" :messages="$errors->get('featured_image')" />
                        @isset($event->featuredImage)
                            <img class="my-2 max-w-80 rounded" src="{{ Storage::url($event->featuredImage->path) }}"
                                alt="{{ $event->name }}" />
                        @endisset
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Event Name')" />
                        <x-text-input id="name" name="name" type="text" :value="old('name', $event->name ?? '')" required
                            :placeholder="__('Enter Event Name')" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="short_brief" :value="__('Event Short Brief')" />
                        <x-textarea id="short_brief" name="short_brief" required
                            :placeholder="__('Enter Event Title Short Brief (Max 200 Characters)')">{{ old('short_brief', $event->short_brief ?? '') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('short_brief')" />
                    </div>

                    <div>
                        <x-input-label for="background_image" :value="__('Background Image')" />
                        <x-file-upload id="background_image" name="background_image" accept="image/*"
                            :required="!isset($event)" />
                        @isset($event->backgroundImage)
                            <img class="my-2 max-w-80 rounded" src="{{ Storage::url($event->backgroundImage->path) }}"
                                alt="{{ $event->name }}" />
                        @endisset
                        <x-input-error class="mt-2" :messages="$errors->get('background_image')" />
                    </div>

                    <div>
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" name="start_date" type="datetime-local" :value="old('start_date', $event->start_date ?? '')"
                            required :placeholder="__('Enter Start Date')" />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                    </div>

                    <div>
                        <x-input-label for="end_date" :value="__('End Date')" />
                        <x-text-input id="end_date" name="end_date" type="datetime-local" :value="old('end_date', $event->end_date ?? '')"
                            :placeholder="__('Enter Start Date')" />
                        <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" :value="old('location', $event->location ?? '')" required
                            :placeholder="__('Enter Location')" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>

                    <div>
                        <x-input-label for="button_text" :value="__('Button Text')" />
                        <x-text-input id="button_text" name="button_text" type="text" :value="old('button_text', $event->button_text ?? 'Attend this Event')"
                            :placeholder="__('Enter Button Text')" />
                        <x-input-error class="mt-2" :messages="$errors->get('button_text')" />
                    </div>

                    <div>
                        <x-input-label for="meeting_link" :value="__('Zoom Meeting Link')" />
                        <x-text-input id="meeting_link" name="meeting_link" type="text" :value="old('meeting_link', $event->meeting_link ?? '')"
                            :placeholder="__('e.g. https://us05web.zoom.us/j/xxxxxxxxxx?pwd=xxxxxx')" />
                        <x-input-error class="mt-2" :messages="$errors->get('meeting_link')" />
                    </div>

                    <div class="space-x-3">
                        <x-input-label for="is_free" :value="__('Is It Free?')" />
                        <x-toggle-input id="is_free" name="is_free" :checked="old('is_free', isset($event) && !$event->price)" />
                    </div>

                    <div id="price_container"
                        style="{{ old('is_free', isset($event) && !$event->price) ? 'display:none;' : 'display:block;' }}">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" name="price" type="number" :value="old('price', $event->price ?? '')" :placeholder="__('Enter Price')"
                            :required="isset($event) && $event->price" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('About this Workshop') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title', $event->title ?? '')" required
                            :placeholder="__('Enter Title')" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="about" :value="__('About')" />
                        <x-textarea id="about" name="about" required
                            :placeholder="__('Enter About')">{{ old('about', $event->about ?? '') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('about')" />
                    </div>

                    <div>
                        <x-input-label for="youtube_link" :value="__('Youtube Link')" />
                        <x-text-input id="youtube_link" name="youtube_link" type="url" :value="old('youtube_link', $event->youtube_link ?? '')"
                            required :placeholder="__('Enter Youtube Link')" />
                        <x-input-error class="mt-2" :messages="$errors->get('youtube_link')" />
                    </div>
                </div>
            </x-card>

            <x-card class="mt-4 p-4">
                <h3 class="mb-2">{{ __('Agenda') }}</h3>
                <div class="space-y-4" id="section-container">
                    @forelse($event->agenda ?? [] as $key => $agenda)
                        <div class="section-item flex gap-4">
                            <div class="flex-1">
                                <x-input-label for="agenda_title" :value="__('Title')" />
                                <x-text-input class="w-full" id="agenda_title"
                                    name="agenda[{{ $key }}][title]" type="text" :value="old('agenda.' . $key . '.title', $agenda['title'])"
                                    required :placeholder="__('Enter Title')" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="agenda_start_time" :value="__('Start Time')" />
                                <x-text-input class="w-full" id="agenda_start_time"
                                    name="agenda[{{ $key }}][start_time]" type="datetime-local"
                                    :value="old('agenda.' . $key . '.start_time', $agenda['start_time'])" required :placeholder="__('Enter Start Time')" />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="agenda_end_time" :value="__('End Time')" />
                                <x-text-input class="w-full" id="agenda_end_time"
                                    name="agenda[{{ $key }}][end_time]" type="datetime-local"
                                    :value="old('sections.' . $key . '.end_time', $agenda['end_time'])" required :placeholder="__('Enter Title')" />
                                <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                            </div>

                            <x-action-button class="remove-section-btn invisible mb-2.5 mt-auto" type="button"
                                color="red" icon="x" />
                        </div>
                    @empty
                        <div class="section-item flex gap-4">
                            <div class="flex-1">
                                <x-input-label for="agenda_title" :value="__('Title')" />
                                <x-text-input class="w-full" id="agenda_title" name="agenda[1][title]"
                                    type="text" :value="old('agenda.1.title')" required :placeholder="__('Enter Title')" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="agenda_start_time" :value="__('Start Time')" />
                                <x-text-input class="w-full" id="agenda_start_time" name="agenda[1][start_time]"
                                    type="datetime-local" :value="old('agenda.1.start_time')" required :placeholder="__('Enter Start Time')" />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="agenda_end_time" :value="__('End Time')" />
                                <x-text-input class="w-full" id="agenda_end_time" name="agenda[1][end_time]"
                                    type="datetime-local" :value="old('sections.1.end_time')" required :placeholder="__('Enter Title')" />
                                <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                            </div>

                            <x-action-button class="remove-section-btn invisible mb-2.5 mt-auto" type="button"
                                color="red" icon="x" />
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <x-primary-button id="add-section" type="button"
                        icon="plus">{{ __('Add New Section') }}</x-primary-button>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('Meet Our Speakers') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="event_speakers" :value="__('Event Speakers')" />
                        <x-select id="event_speakers" name="event_speakers[]" :multiple="true" required>
                            @foreach ($eventSpeakers as $key => $eventSpeaker)
                                <option value="{{ $key }}" @selected(old('event_speakers', isset($event) && $event->eventSpeakers->contains($key)))>{{ $eventSpeaker }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('event_speakers')" />
                    </div>
                </div>
            </x-card>
        </div>
    </form>

    @push('styles')
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/quill.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(function() {
                select('#service_id, #event_type_id, #event_speakers', {
                    placeholder: 'Select an Option'
                });

                $('#is_free').change(function() {
                    let is_free = $(this).is(":checked");

                    if (is_free) {
                        $('#price_container').hide();
                        $('#price').val('').prop('required', false);
                    } else {
                        $('#price_container').show();
                        $('#price').val('').prop('required', true);
                    }
                });

                // Initialize Quill editor on first page load
                // const editorSelector = document.querySelector('.editor')
                // const inputData = document.querySelector('.quill-data');
                //
                // quillEditor(editorSelector, inputData);

                let counter = $('.section-item').length + 1; // Set counter based on current sections

                // When the Add New Section button is clicked
                $('#add-section').click(function() {
                    // Clone the last section-item
                    let newSectionItem = cloneAndSetupSection(counter);

                    // Append the cloned item to the container
                    $('#section-container').append(newSectionItem);

                    // Increment the counter for the next input
                    counter++;

                    updateRemoveButtonVisibility();
                });

                // Event listener for removing a section
                $(document).on('click', '.remove-section-btn', function() {
                    $(this).closest('.section-item').remove(); // Remove the parent section-item

                    // Decrement the counter after a section is removed
                    counter--;

                    $('.section-item').each(function(index) {
                        $(this).find('.section-title').text(`{{ __('Section') }} ${index + 1}`);
                    });

                    updateRemoveButtonVisibility();
                });
            });

            const cloneAndSetupSection = (counter) => {
                const newSectionItem = $('.section-item').last().clone();

                // Make the remove button visible for the new section
                newSectionItem.find('.remove-section-btn').removeClass('invisible');

                // Update the input names with a new index based on the counter
                newSectionItem.find('input[name^="agenda"]').each(function() {
                    let name = $(this).attr('name');
                    name = name.replace(/\[\d+\]/, `[${counter}]`); // Replace the old index with the new counter
                    $(this).attr('name', name);
                });

                {{-- newSectionItem.find('.section-title').text(`{{ __('Section') }} ${counter}`); --}}

                // Clear the input values for text inputs
                newSectionItem.find('input').val('');

                // // Reinitialize the Quill editor for the new section (reset the editor content as well)
                // let newEditor = newSectionItem.find('.editor');
                //
                // // Check if the Quill editor already exists for this element
                // if (!newEditor.hasClass('ql-editor')) {
                //     newSectionItem.find('.ql-toolbar').remove();
                //     newEditor.removeClass('ql-container ql-snow').html('');
                //
                //     // Clear the content of the cloned editor
                //     quillEditor(newEditor[0], newSectionItem.find('.quill-data')[
                //         0]); // Initialize Quill for the new section
                // }

                return newSectionItem;
            }

            const updateRemoveButtonVisibility = () => {
                const $sections = $('.section-item');
                // Show the remove button for the first section only, hide for others
                $sections.each(function(index) {
                    const $removeButton = $(this).find('.remove-section-btn');
                    if ($sections.length > 1) {
                        $removeButton.removeClass('invisible');
                    } else {
                        $removeButton.addClass('invisible');
                    }
                });
            }

            updateRemoveButtonVisibility();

            const formSelector = '#event_form';
            const eventId = $('#event_id').val();

            const save = (name) => {
                $('#status').val(name);

                submitForm(formSelector,
                    () => eventId ? route("events.update", eventId) : route("events.store"),
                    () => eventId ? 'put' : 'post',
                    (response) => {
                        if (response?.success) {
                            location.reload();
                        }
                    },
                    error => {
                        if (error.status === 422) {
                            handleValidationError(error.responseJSON.errors)
                        }
                    }
                );
            }
        </script>
    @endpush
</x-backend-layout>
