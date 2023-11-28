<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{

    public function verify($id)
    {
        // get the user with the id
        $user = User::findOrFail($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));

            return request()->wantsJson()
                ? response()->json('', 204)
                : redirect(url(config('SPA_URL') . '/?verified=1'));
        } else if ($user->hasVerifiedEmail()) {
            return request()->wantsJson()
                ? response()->json('', 204)
                : redirect((env('SPA_URL') . '/login?verified=1'));
        }
    }

    public function resend()
    {
        request()->user()->sendEmailVerificationNotification();
        return response()->json([
            'data' => [
                'message' => 'New email verification link sent!'
            ]
        ]);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Laravel\Fortify\Http\Requests\VerifyEmailRequest  $request
     * @return \Laravel\Fortify\Contracts\VerifyEmailResponse
     */
    // public function __invoke(VerifyEmailRequest $request)
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    // return app(VerifyEmailResponse::class);
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return app(VerifyEmailResponse::class);
    // }
}