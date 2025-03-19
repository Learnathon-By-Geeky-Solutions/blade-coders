<x-backend-layout :title="__('Mailboxes')">
    <x-slot name="header">
        <h1 class="inline-block text-xl font-semibold leading-6">{{ __('Mailboxes') }}</h1>
    </x-slot>

    <x-card>
        <div class="relative overflow-x-auto p-4">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-3" scope="col">{{ __('First Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Last Name') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Email Address') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Phone Number') }}</th>
                        <th class="px-6 py-3" scope="col">{{ __('Subject') }}</th>
                        {{-- <th class="px-6 py-3" scope="col">{{ __('Message') }}</th> --}}
                        <th class="px-6 py-3" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mailboxes as $mailbox)
                        <tr class="{{ $mailbox->read ?: 'bg-gray-100' }} border-b border-gray-300">
                            <td class="px-6 py-3 text-left">{{ $mailbox->mailboxItems()->first()->first_name }}</td>
                            <td class="px-6 py-3 text-left">{{ $mailbox->mailboxItems()->first()->last_name }}</td>
                            <td class="px-6 py-3 text-left">{{ $mailbox->mailboxItems()->first()->email }}</td>
                            <td class="px-6 py-3 text-left">{{ $mailbox->mailboxItems()->first()->phone }}</td>
                            <td class="px-6 py-3 text-left">{{ $mailbox->subject }}</td>
                            {{--                        <td class="px-6 py-3 text-left">{{ Str::limit($mailbox->message, 30) }}</td> --}}
                            <td class="px-6 py-3 text-left">
                                @can('mailbox.view')
                                    <x-action-link data-bs-toggle="tooltip" data-bs-placement="top" :href="route('mailboxes.show', $mailbox->id)"
                                        :data-bs-title="__('View')" color="blue" icon="eye" />
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-3 text-center" colspan="100%">{{ __('No Data Found!') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $mailboxes->links() }}
            </div>
        </div>
    </x-card>
</x-backend-layout>
