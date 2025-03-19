<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetLinkSendController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        abort_if($user->id == auth()->id(), Response::HTTP_FORBIDDEN);

        Gate::authorize('user.update');

        $status = Password::sendResetLink(
            ['email' => $user->email]
        );

        return $status == Password::RESET_LINK_SENT
            ? response()->json([
                'status' => true,
                'message' => __('Password reset link sent for user :id', ['id' => __($user->email)]),
            ])
            : response()->json(
                [
                    'status' => false,
                ]
            );
    }
}
