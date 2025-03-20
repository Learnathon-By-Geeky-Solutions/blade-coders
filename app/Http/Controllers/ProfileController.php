<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\MediaUploadService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly MediaUploadService $mediaUploadService
    ) {
        //
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('backend.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            if ($user instanceof MustVerifyEmail) {
                $user->sendEmailVerificationNotification();
            }

            $user->email_verified_at = null;
        }

        if ($request->has('avatar')) {
            if ($user->avatar) {
                $this->mediaUploadService->deleteMedia($user->avatar);
            }

            $this->mediaUploadService->uploadSingle($request->file('avatar'), $user, 'avatars', 'avatar');
        }

        $request->user()->save();

        toastr()->success('Information updated successfully.');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
