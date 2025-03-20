@use('\App\Enums\BlogStatus')

<x-backend-layout :title="__('Blog')">
    <div class="mb-4 flex items-center justify-between border-b border-gray-300 pb-4">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Edit Blog') }}</h1>
        <div class="flex space-x-4">
            @can('blog.create')
                <x-secondary-button form="blog-form" type="submit" onclick="save(`{{ BlogStatus::DRAFT->value }}`)"
                    icon="save">{{ __('Draft') }}</x-secondary-button>
                <x-primary-button form="blog-form" type="submit" onclick="save(`{{ BlogStatus::PUBLISH->value }}`)"
                    icon="send">{{ __('Publish') }}</x-primary-button>
            @endcan
        </div>
    </div>

    <form id="blog-form" action="{{ route('blogs.update', $blog->id) }}" enctype="multipart/form-data">
        <input id="status" type="hidden" name="status">

        <x-card class="p-4">
            <h3>{{ __('Blog information') }}</h3>
            <div class="mt-3 space-y-3">
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" :value="old('title', $blog->title)" required
                        autocomplete="off" placeholder="{{ __('ex: Know about Bellspalsy') }}" />
                </div>
                <div>
                    <x-input-label for="subtitle" :value="__('Short Brief')" />
                    <x-textarea id="subtitle" name="subtitle" autocomplete="off" :placeholder="__('Enter Blog Title Short Brief (Max 200 Characters)')">
                        {{ old('subtitle', $blog->subtitle) }}
                    </x-textarea>
                </div>
                <div>
                    <x-input-label for="banner" :value="__('Hero Background Image')" />
                    @if ($blog->banner)
                        <img class="h-20 w-80 rounded-lg mb-4" src="{{ $blog->banner->path }}" alt="img" />
                    @endif
                    <x-file-upload id="banner" name='banner' />
                </div>
                <div>
                    <x-input-label for="feature_image" :value="__('Feature Image')" />
                    @if ($blog->featureImage)
                        <img class="h-20 w-80 rounded-lg mb-4" src="{{ $blog->featureImage->path }}" alt="img" />
                    @endif
                    <x-file-upload id="feature_image" name='feature_image' />
                </div>
                <div>
                    <x-input-label for="category" :value="__('Category')" />
                    <select
                        class="w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        id="category" name="blog_category_id">
                        <option value="" selected disabled>
                            {{ __('Select Blog Category') }}
                        </option>
                        @foreach ($blogCategories as $blogCategory)
                            <option value="{{ $blogCategory->id }}" {{ $blog->blog_category_id == $blogCategory->id ? 'selected' : '' }}>
                                {{ $blogCategory->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-card>
        <div id="section-container">
            @foreach ($blog->sections as $index => $section)
                <x-card class="section-item mt-4 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="section-title">{{ __('Section ' . $index) }}</h3>
                        <x-action-button class="remove-section-btn hidden" type="button" color="red">
                            <i class="size-4" data-feather="x"></i>
                        </x-action-button>
                    </div>
                    <div class="mt-3 space-y-3">
                        <div>
                            <x-input-label for="title" :value="__('Enter Title')" />
                            <x-text-input id="title" name="sections[{{ $index }}][title]" :value="$section['title']" type="text" required />
                        </div>
                        <div>
                            <x-input-label :value="__('Content')" />
                            <div class="editor !h-[250px] rounded-b !text-lg text-black">{!! $section['content'] !!}</div>
                            <input class="quill-data" name="sections[{{ $index }}][content]"
                                value="{{ $section['content'] }}" type="hidden" />
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </form>

    <div class="mt-4">
        <x-primary-button id="add-section" type="button" icon="plus">{{ __('Add New Section') }}</x-primary-button>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/quill.js') }}"></script>
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
        <script>
            $(function () {
                // Initialize Quill editor on first page load
                const editorSelector = document.querySelectorAll('.editor')
                const inputData = document.querySelectorAll('.quill-data');
                $(editorSelector).each(function (index, value) {
                    quillEditor(value, inputData[index]);
                })

                let counter = $('.section-item').length + 1; // Set counter based on current sections

                // When the Add New Section button is clicked
                $('#add-section').click(function () {
                    let newSectionItem = cloneAndSetupSection(counter);

                    $('#section-container').append(newSectionItem);

                    counter++;

                    updateRemoveButtonVisibility();
                });

                // Event listener for removing a section
                $(document).on('click', '.remove-section-btn', function () {
                    $(this).closest('.section-item').remove(); // Remove the parent section-item

                    counter--;

                    $('.section-item').each(function (index) {
                        $(this).find('.section-title').text(`{{ __('Section') }} ${index + 1}`);

                        $(this).find('input[name^="sections"]').each(function () {
                            let name = $(this).attr('name');
                            name = name.replace(/\[\d+\]/, `[${index + 1}]`);
                            $(this).attr('name', name);
                        });
                    });

                    updateRemoveButtonVisibility();
                });
            });

            const cloneAndSetupSection = (counter) => {
                const newSectionItem = $('.section-item').last().clone();

                newSectionItem.find('.remove-section-btn').removeClass('hidden');

                // Update the input names with a new index based on the counter
                newSectionItem.find('input[name^="sections"]').each(function () {
                    let name = $(this).attr('name');
                    name = name.replace(/\[\d+\]/, `[${counter}]`); // Replace the old index with the new counter
                    $(this).attr('name', name);
                });

                newSectionItem.find('.section-title').text(`{{ __('Section') }} ${counter}`);

                // Clear the input values for text inputs
                newSectionItem.find('input').val('');

                // Reinitialize the Quill editor for the new section (reset the editor content as well)
                let newEditor = newSectionItem.find('.editor');

                // Check if the Quill editor already exists for this element
                if (!newEditor.hasClass('ql-editor')) {
                    newSectionItem.find('.ql-toolbar').remove();
                    newEditor.removeClass('ql-container ql-snow').html('');

                    // Clear the content of the cloned editor
                    quillEditor(newEditor[0], newSectionItem.find('.quill-data')[0]); // Initialize Quill for the new section
                }

                return newSectionItem;
            }

            const updateRemoveButtonVisibility = () => {
                const $sections = $('.section-item');
                // Show the remove button except first section
                $sections.each(function (index) {
                    const $removeButton = $(this).find('.remove-section-btn');
                    if ($sections.length > 1) {
                        $removeButton.removeClass('hidden');
                    } else {
                        $removeButton.addClass('hidden');
                    }
                });
            }

            updateRemoveButtonVisibility();

            const save = (name) => {
                $('#status').val(name);

                const formSelector = '#blog-form';

                const url = $('#blog-form').attr('action');
                const method = 'PUT';

                submitForm(formSelector,
                    () => url,
                    () => method,
                    (response) => {
                        if (response.success) {
                            window.location = "{{ route('blogs.index') }}";
                        }
                    },
                    (error) => {
                        $('.error').remove();
                        if (error.status === 422) {
                            let errors = error.responseJSON.errors;
                            if (errors) {
                                $.each(errors, (field, messages) => {
                                    field = field.replace(/sections\.(\d+)\.(\w+)/, 'sections\\[$1\\]\\[$2\\]');

                                    const fieldName = $('[name=' + field + ']');

                                    fieldName.after(`<span class="error">${messages[0]}</span>`);
                                });
                            }
                        }
                    },
                )
            }
        </script>
    @endpush
</x-backend-layout>