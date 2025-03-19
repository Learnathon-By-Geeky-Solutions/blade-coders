<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Mailbox;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('mailbox.viewAny');

        $mailboxes = Mailbox::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.mailboxes.index', compact('mailboxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mailbox $mailbox): View
    {
        Gate::authorize('mailbox.view');

        $mailbox->update(['read' => true]);

        return view('backend.mailboxes.show', compact('mailbox'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mailbox $mailbox): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mailbox $mailbox): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mailbox $mailbox): void
    {
        //
    }

    public function send(Request $request, Mailbox $mailbox): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email:rfc'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:15'],
        ]);

        Mail::to(users: $request->input('email'))->send(new ContactMail(subject: $request->input('subject'), message: $request->input('message')));

        $mailbox->update(['replied' => true]);

        $user = auth()->user();

        [$firstName, $lastName] = explode(' ', $user->name);

        $mailbox->mailboxItems()->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $user->email,
            // 'phone' => $user->phone,
            'message' => $request->input('message'),
            'read' => false,
            'is_admin' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Mail has been sent.']);
    }
}
