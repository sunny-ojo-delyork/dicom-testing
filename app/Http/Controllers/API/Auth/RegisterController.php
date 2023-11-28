<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteProfileRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register (RegisterRequest $request) {
    $registerRequest = $request->validated();
   
    DB::beginTransaction();
    try {
     
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($registerRequest['password']),
        ]);
        $token = $user->createToken('authToken');
        $user->sendEmailVerificationNotification();
        DB::commit();
        return $this->successResponse(['user' => $user, 'token' => $token->plainTextToken], 'Account created successfully', 201);
    } catch (\Throwable $th) {
        DB::rollBack();
        Log::error("failed to register user. Reason: ".$th->getMessage());
       return $this->errorResponse([], 'Failed to register user, please try again');
    }
    }

    public function completeProfile (CompleteProfileRequest $request) {
    $data= $request->validated(); 
    try {
        Auth::user()->update([
        'name' => $data['name'],
        'type' => $data['type'],
        'address' => $data['address'] ?? null,
        'country' => $data['country'] ?? null,
        'notify_on_updates' => $data['notify_on_updates'] ?? false,
        'notify_on_events_and_virtual_exhibitions' => $data['notify_on_events_and_virtual_exhibitions'] ?? false,
    ]);
        return $this->successResponse(['user' => Auth::user()->refresh()], 'Profile updated successfully', 201);
    } catch (\Throwable $th) {
        Log::error("failed to update profile. Reason: ".$th->getMessage());
       return $this->errorResponse([], 'Failed to update user, please try again');
    }

    }
}
