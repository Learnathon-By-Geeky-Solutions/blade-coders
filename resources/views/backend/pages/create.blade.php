@use('\App\Enums\PageStatus')

<x-backend-layout :title="__('Custom page')">
    <div class="mb-4 flex items-center justify-between border-b border-gray-300 pb-4">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Create Custom Page') }}</h1>
        <div class="flex space-x-4">
            @can('page.create')
                <x-primary-button form="page-form" onclick="submitForm(`{{ PageStatus::DRAFT->value }}`)">{{ __('Draft') }}</x-primary-button>
                <x-primary-button form="page-form" onclick="submitForm(`{{ PageStatus::PUBLISH->value }}`)">{{ __('Publish') }}</x-primary-button>
            @endcan
            <x-secondary-link href="{{ route('pages.index') }}">{{ __('Back') }}</x-secondary-link>
        </div>
    </div>

    <x-card>
        <div class="p-4">
            <form id="page-form" method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="mb-3">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title')" required autocomplete="off" placeholder="{{ __('ex: Terms of Service') }}" />
                        <x-input-error class="error mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div class="mb-3 mt-4">
                        <x-input-label for="subtitle" :value="__('Sub Title')" />
                        <x-textarea-input id="subtitle" name="subtitle" :value="old('subtitle', '')" autocomplete="off"/>
                        <x-input-error class="error mt-2" :messages="$errors->get('subtitle')" />
                    </div>
                    <div class="mb-0 mt-4 inline-flex w-full flex-col gap-3 md:flex md:flex-row md:items-center">
                        <div class="flex-1">
                            <x-input-label for="banner" :value="__('Banner Image')"/>
                        </div>
                        <div class="flex-[3]">
                            <input id="banner" name="banner" accept="image/png, image/jpeg" type="file"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-600 dark:file:text-violet-100 dark:hover:file:bg-violet-500">
                            <x-input-error class="mt-2" :messages="$errors->get('banner')" />
                        </div>
                    </div>
                    <div class="mb-3 mt-4">
                        <x-input-label for="content" :value="__('Page Content')" />
                        <div class="!h-[250px] rounded-b !text-lg text-black" id="editor"></div>
                        <input id="quill-data" name="content" type="hidden" :value="old('content')"/>
                        <x-input-error class="error mt-2" :messages="$errors->get('content')" />
                    </div>

                    <input type="hidden" id="status" name="status" value="">
                    <x-input-error class="error mt-2" :messages="$errors->get('status')" />
                </div>
            </form>
        </div>
    </x-card>

    @push('scripts')
        <script src="{{ asset('assets/js/quill.js') }}"></script>
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
        <script>
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote'],
                ['link', 'image', 'video'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['clean']
            ];
            const options = {
                placeholder: 'Type something here',
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            };
            const quill = new Quill('#editor', options);
            const inputData = document.getElementById('quill-data');

            const initialContent = @json(old('content'));
            quill.clipboard.dangerouslyPasteHTML(initialContent);

            quill.on('text-change', function() {
                inputData.value = quill.root.innerHTML;
            });

            // Form submission
            function submitForm(status) {
                const statusField = document.getElementById('status');

                statusField.value = status;
            }
        </script>
    @endpush
</x-backend-layout>
