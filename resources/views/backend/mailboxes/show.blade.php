<x-backend-layout :title="__('Mail Details')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Mail Details') }}</h1>
    </x-slot>

    <div class="space-y-4">
        <x-card>
            <header class="flex items-center justify-between border-b border-gray-300 px-4 py-2">
                <div>
                    <h3 class="text-lg">{{ $mailbox->subject }}</h3>
                    {{-- <h4 class="text-base">   --}}
                    {{--     {{ $mailbox->name }}   --}}
                    {{--     <span class="text-sm">({{ $mailbox->email }})</span>   --}}
                    {{--     @if ($mailbox->phone)   --}}
                    {{--         <span class="text-sm">({{ $mailbox->phone }})</span>   --}}
                    {{--     @endif   --}}
                    {{-- </h4>   --}}
                </div>
                {{-- <div class="flex items-center justify-between gap-2">  --}}
                {{--     <p>{{ $mailbox->created_at->diffForHumans() }}</p>  --}}
                {{--     <x-primary-button  --}}
                {{--         data-bs-toggle="modal"  --}}
                {{--         data-bs-target="#replyMailModal"  --}}
                {{--         class="inline-flex gap-2 items-center">  --}}
                {{--         <i class="size-4" data-feather="corner-up-right"></i>  --}}
                {{--         {{ __('Reply') }}  --}}
                {{--     </x-primary-button>  --}}
                {{-- </div>  --}}
            </header>
            <main class="space-y-2 p-4">
                @foreach ($mailbox->mailboxItems as $item)
                    @if (!$item->is_admin)
                        <div class="flex items-center gap-2">
                            <div>
                                <img class="size-10 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ $item->name }}"
                                    alt="{{ $item->name }}" />
                            </div>
                            <div>
                                <h4 class="text-base">{{ $item->name }}</h4>
                                <p>{{ $mailbox->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div>
                            {{ $item->message }}
                        </div>
                    @else
                        <div class="flex items-center justify-end gap-2">
                            <div class="text-right">
                                <h4 class="text-base">{{ $item->name }}</h4>
                                <p>{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <img class="size-10 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ $item->name }}"
                                    alt="{{ $item->name }}" />
                            </div>
                        </div>
                        <div class="text-right">
                            {!! $item->message !!}
                        </div>
                    @endif
                @endforeach
            </main>
            @if (!$mailbox->replied)
                <footer class="border-t border-gray-300 px-4 py-2">
                    <x-primary-button class="inline-flex items-center gap-2 px-3 py-1.5" data-bs-toggle="collapse"
                        data-bs-target="#reply" aria-expanded="false" aria-controls="reply">
                        <i class="size-4" data-feather="send"></i> {{ __('Reply') }}
                    </x-primary-button>
                </footer>
            @endif
        </x-card>

        <div class="collapse" id="reply">
            <x-card>
                <div class="p-4">
                    <form data-id="{{ $mailbox->id }}" method="POST"
                        action="{{ route('mailboxes.send', $mailbox->id) }}">
                        @csrf
                        <div>
                            <div class="space-y-2">
                                <x-text-input name="email" type="text" :value="old('to', $mailbox->mailboxItems()->first()->email)" required
                                    autocomplete="off" placeholder="{{ __('To') }}" />
                                <x-text-input name="subject" type="text" :value="old('subject', 'Reply: ' . $mailbox->subject)" required
                                    autocomplete="off" placeholder="{{ __('Subject') }}" />
                            </div>
                            <div class="mt-2">
                                <div class="!h-[250px] rounded-b !text-lg text-black" id="editor"></div>
                                <input id="quill-data" name="message" type="hidden" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-primary-button class="flex">
                                <span class="hidden" id="loading">
                                    <svg class="-ml-1 mr-3 size-5 animate-spin text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                {{ __('Send') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>
    </div>

    {{-- <div class="modal fade compose-mail" id="replyMailModal" tabindex="-1" aria-hidden="true"> --}}
    {{--     <div class="modal-dialog modal-dialog-centered modal-xl"> --}}
    {{--         <div class="modal-content"> --}}
    {{--             <div class="modal-header"> --}}
    {{--                 <h5 class="modal-title" id="exampleModalLabel">{{ __('Reply') }}</h5> --}}
    {{--                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> --}}
    {{--                     <svg --}}
    {{--                         xmlns="http://www.w3.org/2000/svg" --}}
    {{--                         class="text-gray-700" --}}
    {{--                         width="24" --}}
    {{--                         height="24" --}}
    {{--                         viewBox="0 0 24 24" --}}
    {{--                         stroke-width="2" --}}
    {{--                         stroke="currentColor" --}}
    {{--                         fill="none" --}}
    {{--                         stroke-linecap="round" --}}
    {{--                         stroke-linejoin="round" --}}
    {{--                     > --}}
    {{--                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> --}}
    {{--                         <path d="M18 6l-12 12"></path> --}}
    {{--                         <path d="M6 6l12 12"></path> --}}
    {{--                     </svg> --}}
    {{--                 </button> --}}
    {{--             </div> --}}
    {{--             <form method="POST" data-id="{{ $mailbox->id }}" action="{{ route('mailboxes.send', $mailbox->id) }}"> --}}
    {{--                 @csrf --}}
    {{--                 <div class="modal-body p-0"> --}}
    {{--                     <div class="space-y-2"> --}}
    {{--                         <x-text-input name="email" type="text" :value="old('to', $mailbox->email)" required --}}
    {{--                                       autocomplete="off" --}}
    {{--                                       placeholder="{{ __('To') }}"/> --}}
    {{--                         <x-text-input name="subject" type="text" --}}
    {{--                                       :value="old('subject', 'Reply: '. $mailbox->subject)" required --}}
    {{--                                       autocomplete="off" placeholder="{{ __('Subject') }}"/> --}}
    {{--                     </div> --}}
    {{--                     <div class="mt-2"> --}}
    {{--                         <div id="editor" class="rounded-b !h-[250px] text-black !text-base"></div> --}}
    {{--                         <input type="hidden" name="message" id="quill-data"/> --}}
    {{--                     </div> --}}
    {{--                 </div> --}}
    {{--                 <div class="modal-footer"> --}}
    {{--                     <x-primary-button class="flex"> --}}
    {{--                         <span id="loading" class="hidden"> --}}
    {{--                             <svg class="mr-3 -ml-1 size-5 animate-spin text-white" --}}
    {{--                                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> --}}
    {{--                                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" --}}
    {{--                                         stroke-width="4"></circle> --}}
    {{--                                 <path class="opacity-75" fill="currentColor" --}}
    {{--                                       d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path> --}}
    {{--                             </svg> --}}
    {{--                         </span> --}}
    {{--                         {{ __('Send') }} --}}
    {{--                     </x-primary-button> --}}
    {{--                 </div> --}}
    {{--             </form> --}}
    {{--         </div> --}}
    {{--     </div> --}}
    {{-- </div> --}}

    @push('scripts')
        <script src="{{ asset('assets/js/quill.js') }}"></script>
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
        <script>
            // const modal = new bootstrap.Modal('#replyMailModal');

            quillEditor('#editor', '#quill-data');

            $('form').submit(function(e) {
                e.preventDefault();

                $('form button').attr('disabled', true)
                $('#loading').show();

                const id = $(this).data('id');
                const email = $('input[name=email]').val();
                const subject = $('input[name=subject]').val();
                const message = $('input[name=message]').val();

                const mailSendUrl = route('mailboxes.send', id);

                sendRequest('POST', mailSendUrl, {
                    email: email,
                    subject: subject,
                    message: message
                }, (response) => {
                    $('#loading').hide();
                    $('form').trigger('reset');

                    if (response.success) {
                        toast('Success!', response.message, 'success', false, (result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        toast("Can't delete", response.message, 'warning', false);
                    }
                }, (error) => {
                    $('form button').attr('disabled', false)
                    $('#loading').hide();

                    toast('Error!', error.responseJSON?.message, 'error', false);
                });
            });
        </script>
    @endpush
</x-backend-layout>
