@use('App\Enums\ServiceStatus')

<x-backend-layout :title="isset($service->id) ? __('Edit Service') : __('Create Service')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">
            {{ isset($service->id) ? __('Edit Service') : __('Create Service') }}</h1>
        <div>
            <x-secondary-button form="service_form" type="submit" onclick="save('{{ ServiceStatus::DRAFT }}')"
                icon="save">{{ __('Draft') }}</x-secondary-button>
            <x-primary-button form="service_form" type="submit" onclick="save('{{ ServiceStatus::PUBLISHED }}')"
                icon="send">{{ __('Publish') }}</x-primary-button>
        </div>
    </x-slot>

    <form id="service_form" method="POST"
        action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}"
        enctype="multipart/form-data">
        @csrf
        @isset($service)
            @method('PUT')
        @endisset
        <input id="status" name="status" type="hidden">

        <div class="space-y-4">
            <x-card class="p-4">
                <h3>{{ __('Service Information') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="icon" :value="__('Service Icon')" />
                        <x-file-upload id="icon" name="icon" accept="image/*" :required="!isset($service)" />
                        <x-input-error class="mt-2" :messages="$errors->get('icon')" />
                        @isset($service->icon)
                            <img class="my-2 max-w-80 rounded" src="{{ Storage::url($service->icon->path) }}"
                                alt="{{ $service->name }}" />
                        @endisset
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Service Name')" />
                        <x-text-input id="name" name="name" type="text" :value="old('name', $service->name ?? '')" required
                            :placeholder="__('Enter Service Name')" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="short_brief" :value="__('Service Short Brief')" />
                        <x-textarea id="short_brief" name="short_brief" required
                            :placeholder="__('Enter Service Title Short Brief (Max 200 Characters)')">{{ old('short_brief', $service->short_brief ?? '') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('short_brief')" />
                    </div>

                    <div>
                        <x-input-label for="background_image" :value="__('Background Image')" />
                        <x-file-upload id="background_image" name="background_image" accept="image/*"
                            :required="!isset($service)" />
                        @isset($service->backgroundImage)
                            <img class="my-2 max-w-80 rounded" src="{{ Storage::url($service->backgroundImage->path) }}"
                                alt="{{ $service->name }}" />
                        @endisset
                        <x-input-error class="mt-2" :messages="$errors->get('background_image')" />
                    </div>

                    <div>
                        <x-input-label for="button_link" :value="__('Button Link')" />
                        <x-text-input id="button_link" name="button_link" type="url" :value="old('button_link', $service->button_link ?? '')" required
                            :placeholder="__('Enter Button Link')" />
                        <x-input-error class="mt-2" :messages="$errors->get('button_link')" />
                    </div>

                    <div>
                        <x-input-label for="button_text" :value="__('Button Text')" />
                        <x-text-input id="button_text" name="button_text" type="text" :value="old('button_text', $service->button_text ?? '')" required
                            :placeholder="__('Enter Button Text')" />
                        <x-input-error class="mt-2" :messages="$errors->get('button_text')" />
                    </div>

                    <div class="space-x-3">
                        <x-input-label for="is_free" :value="__('Is It Free?')" />
                        <x-toggle-input id="is_free" name="is_free" :checked="old('is_free', isset($service) && !$service->price)" />
                    </div>

                    <div id="price_container"
                        style="{{ old('is_free', isset($event) && !$event->price) ? 'display:none;' : 'display:block;' }}">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" name="price" type="number" :value="old('price', $service->price ?? '')" :placeholder="__('Enter Price')"
                            :required="!isset($service) || !$service->price" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('Our Service') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title', $service->title ?? '')" required
                            :placeholder="__('Enter Title')" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="about" :value="__('About')" />
                        <x-textarea id="about" name="about" required
                            :placeholder="__('Enter About')">{{ old('about', $service->about ?? '') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('about')" />
                    </div>

                    <div>
                        <x-input-label for="youtube_link" :value="__('Youtube Link')" />
                        <x-text-input id="youtube_link" name="youtube_link" type="url" :value="old('youtube_link', $service->youtube_link ?? '')" required
                            :placeholder="__('Enter Youtube Link')" />
                        <x-input-error class="mt-2" :messages="$errors->get('youtube_link')" />
                    </div>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('Key Benefits') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="benefits" :value="__('Key Benefits')" />
                        <x-select id="benefits" name="benefits[]" :multiple="true" required>
                            @foreach ($benefits as $key => $benefit)
                                <option value="{{ $key }}" @selected(old('benefits', isset($service) && $service->benefits->contains($key)))>{{ $benefit }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
                    </div>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('Ability Support') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="ability_supports" :value="__('Ability Supports')" />
                        <x-select id="ability_supports" name="ability_supports[]" :multiple="true" required>
                            @foreach ($abilitySupports as $key => $benefit)
                                <option value="{{ $key }}" @selected(old('ability_supports', isset($service) && $service->abilitySupports->contains($key)))>{{ $benefit }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('ability_supports')" />
                    </div>

                    <div>
                        <x-input-label for="ability_support_image" :value="__('Ability Support Image')" />
                        <x-file-upload id="ability_support_image" name="ability_support_image" accept="image/*"
                            :required="!isset($service)" />
                        @isset($service->abilitySupportImage)
                            <img class="my-2 max-w-80 rounded"
                                src="{{ Storage::url($service->abilitySupportImage->path) }}"
                                alt="{{ $service->name }}" />
                        @endisset
                        <x-input-error class="mt-2" :messages="$errors->get('ability_support_image')" />
                    </div>
                </div>
            </x-card>

            <x-card class="p-4">
                <h3>{{ __('Our Process') }}</h3>
                <div class="mt-3 space-y-3">
                    <div>
                        <x-input-label for="our_processes" :value="__('Our Processes')" />
                        <x-select id="our_processes" name="our_processes[]" :multiple="true" required>
                            @foreach ($ourProcesses as $key => $benefit)
                                <option value="{{ $key }}" @selected(old('our_processes', isset($service) && $service->ourProcesses->contains($key)))>{{ $benefit }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('our_processes')" />
                    </div>
                </div>
            </x-card>

            {{-- <div id="section-container"> --}}
            {{--     <x-card class="section-item mt-4 p-4"> --}}
            {{--         <div class="flex items-center justify-between"> --}}
            {{--             <h3 class="section-title">{{ __('Section 1') }}</h3> --}}
            {{--             <x-action-button class="remove-section-btn hidden" type="button" color="red" icon="x" /> --}}
            {{--         </div> --}}
            {{--         <div class="mt-3 space-y-3"> --}}
            {{--             <div> --}}
            {{--                 <x-input-label for="title" :value="__('Enter Title')"/> --}}
            {{--                 <x-text-input id="title" name="sections[1][title]" type="text" :value="old('title')" --}}
            {{--                               required/> --}}
            {{--                 <x-input-error class="mt-2" :messages="$errors->get('title')"/> --}}
            {{--             </div> --}}
            {{--             <div> --}}
            {{--                 <x-input-label :value="__('Enter Description')"/> --}}
            {{--                 <div class="editor !h-[250px] rounded-b !text-lg text-black"></div> --}}
            {{--                 <input class="quill-data" name="sections[1][description]" type="hidden"/> --}}
            {{--                 <x-input-error class="mt-2" :messages="$errors->get('description')"/> --}}
            {{--             </div> --}}
            {{--         </div> --}}
            {{--     </x-card> --}}
            {{-- </div> --}}
        </div>
    </form>

    {{-- <div class="mt-4"> --}}
    {{--     <x-primary-button id="add-section" type="button" icon="plus">{{ __('Add New Section') }}</x-primary-button> --}}
    {{-- </div> --}}

    @push('styles')
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/js/quill.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(function() {
                select('#benefits, #ability_supports, #our_processes');

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

                {{-- // Initialize Quill editor on first page load --}}
                {{-- const editorSelector = document.querySelector('.editor') --}}
                {{-- const inputData = document.querySelector('.quill-data'); --}}

                {{-- quillEditor(editorSelector, inputData); --}}

                {{-- let counter = $('.section-item').length + 1; // Set counter based on current sections --}}

                {{-- // When the Add New Section button is clicked --}}
                {{-- $('#add-section').click(function () { --}}
                {{--    // Clone the last section-item --}}
                {{--    let newSectionItem = cloneAndSetupSection(counter); --}}

                {{--    // Append the cloned item to the container --}}
                {{--    $('#section-container').append(newSectionItem); --}}

                {{--    // Increment the counter for the next input --}}
                {{--    counter++; --}}

                {{--    updateRemoveButtonVisibility(); --}}
                {{-- }); --}}

                {{-- // Event listener for removing a section --}}
                {{-- $(document).on('click', '.remove-section-btn', function () { --}}
                {{--    $(this).closest('.section-item').remove(); // Remove the parent section-item --}}

                {{--    // Decrement the counter after a section is removed --}}
                {{--    counter--; --}}

                {{--    $('.section-item').each(function (index) { --}}
                {{--        $(this).find('.section-title').text(`{{ __('Section') }} ${index + 1}`); --}}
                {{--    }); --}}

                {{--    updateRemoveButtonVisibility(); --}}
                {{-- }); --}}
            });

            {{-- const cloneAndSetupSection = (counter) => { --}}
            {{--    const newSectionItem = $('.section-item').last().clone(); --}}

            {{--    // Make the remove button visible for the new section --}}
            {{--    newSectionItem.find('.remove-section-btn').removeClass('hidden'); --}}

            {{--    // Update the input names with a new index based on the counter --}}
            {{--    newSectionItem.find('input[name^="sections"]').each(function () { --}}
            {{--        let name = $(this).attr('name'); --}}
            {{--        name = name.replace(/\[\d+\]/, `[${counter}]`); // Replace the old index with the new counter --}}
            {{--        $(this).attr('name', name); --}}
            {{--    }); --}}

            {{--    newSectionItem.find('.section-title').text(`{{ __('Section') }} ${counter}`); --}}

            {{--    // Clear the input values for text inputs --}}
            {{--    newSectionItem.find('input').val(''); --}}

            {{--    // Reinitialize the Quill editor for the new section (reset the editor content as well) --}}
            {{--    let newEditor = newSectionItem.find('.editor'); --}}

            {{--    // Check if the Quill editor already exists for this element --}}
            {{--    if (!newEditor.hasClass('ql-editor')) { --}}
            {{--        newSectionItem.find('.ql-toolbar').remove(); --}}
            {{--        newEditor.removeClass('ql-container ql-snow').html(''); --}}

            {{--        // Clear the content of the cloned editor --}}
            {{--        quillEditor(newEditor[0], newSectionItem.find('.quill-data')[ --}}
            {{--            0]); // Initialize Quill for the new section --}}
            {{--    } --}}

            {{--    return newSectionItem; --}}
            {{-- } --}}

            {{-- const updateRemoveButtonVisibility = () => { --}}
            {{--    const $sections = $('.section-item'); --}}
            {{--    // Show the remove button for the first section only, hide for others --}}
            {{--    $sections.each(function (index) { --}}
            {{--        const $removeButton = $(this).find('.remove-section-btn'); --}}
            {{--        if ($sections.length > 1) { --}}
            {{--            $removeButton.removeClass('hidden'); --}}
            {{--        } else { --}}
            {{--            $removeButton.addClass('hidden'); --}}
            {{--        } --}}
            {{--    }); --}}
            {{-- } --}}

            {{-- updateRemoveButtonVisibility(); --}}

            const save = (name) => {
                $('#status').val(name);
            }
        </script>
    @endpush
</x-backend-layout>
