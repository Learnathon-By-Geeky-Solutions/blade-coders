<x-backend-layout>
    <div class="mb-4 flex items-center justify-between border-b border-gray-300 pb-4">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ $language->name }} {{ __('Translation') }}</h1>
        <x-secondary-link href="{{ route('languages.index') }}">{{ __('Back') }}</x-secondary-link>
    </div>

    <x-card>
        <div class="p-4">
            <form method="POST" action="{{ route('languages.translation', $language->id) }}">
                @csrf

                <div id="translations-container">
                    @foreach($translations as $key => $translation)
                        <div class="grid grid-cols-2 gap-4 relative translation-item">
                            <div class="mb-3">
                                <x-text-input name="translations[{{ $loop->index }}][key]" type="text" :value="$key"
                                              required autofocus autocomplete="off" placeholder="Enter Key" readonly/>
                            </div>
                            <div class="mb-5">
                                <x-text-input name="translations[{{ $loop->index }}][value]" type="text"
                                              :value="$translation" required autofocus autocomplete="off"
                                              placeholder="Enter Value"/>
                            </div>
                            <div class="absolute top-2.5 right-2.5">
                                <x-action-button type="button" class="remove-translation-btn" color="red">
                                    <i class="size-4" data-feather="trash"></i>
                                </x-action-button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-center gap-4">
                    <x-secondary-button type="button" id="add-translation">Add Another Translation</x-secondary-button>
                    <x-primary-button>{{ __('Submit') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function () {
                let counter = {{ count($translations) }}; // Initialize the counter based on current translations count

                // When the Add Another Translation button is clicked
                $('#add-translation').click(function () {
                    // Clone the last translation-item
                    let newTranslationItem = $('.translation-item').last().clone();

                    // Update the input names with a new index based on counter
                    newTranslationItem.find('input[name^="translations"]').each(function () {
                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, `[${counter}]`); // Replace the old index with the new counter
                        $(this).attr('name', name);
                    });

                    // Clear the input values (optional, depending on your preference)
                    newTranslationItem.find('input').val('');

                    // Remove readonly from the key field and ensure both fields are required
                    newTranslationItem.find('input[name$="[key]"]').removeAttr('readonly').attr('required', true); // Make key field editable and required
                    newTranslationItem.find('input[name$="[value]"]').attr('required', true); // Make value field required

                    // Append the cloned item to the container
                    $('#translations-container').append(newTranslationItem);

                    // Increment the counter for the next input
                    counter++;
                });

                $(document).on('click', '.remove-translation-btn', function () {
                    $(this).closest('.translation-item').remove(); // Remove the parent translation-item
                });
            });
        </script>
    @endpush
</x-backend-layout>
