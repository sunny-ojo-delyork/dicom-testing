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

    public function getPayApplicationFeeByVoucher(Request $request)
    {
        $this->validate($request, [
            'voucher'=> 'required'
        ]);
        
        $voucher = Voucher::where(['code' => $request->post('voucher')])->first();

        if ($voucher != null) {


            $today = date_create(date('Y-m-d'));
            $expiry_date = date_create($voucher->expiry_date);

            $dateObject = date_diff($today, $expiry_date);

            if ($voucher === null || $voucher->status == 'used') {

                return back()->with('error', 'The voucher has already been used.');


            } elseif ($voucher->status == 'not used' && (int)$dateObject->format("%a") < 0) {

                //Expired
                return back()->with('error', 'The voucher entered  has expired.');


            } else {

                $payment = Payment::firstOrCreate([

                    'reference_no' => $this->generateUniqueTransactionCode(),
                    'amount' => $request->amount,
                    'email_address' => Session::get('student_info')->email_address,
                    'currency' => 'voucher',
                    'status' => 'success',
                    'channel' => 'voucher',
                    'description' => 'Registration fee',
                    'method' => 'onine',
                    'voucher_id' => $voucher->id,
                    'type' => 0,
                    'plan' => 'full',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')


                ]);

                if ($payment) {

                    $voucher::where('id', $voucher->id)->update(['status' => 'used']);
                    Session::put('user_email', $payment->email_address);
                    return Redirect::route('student.register');

                }

            }

        } else {
            return back()->with('error', 'Voucher code entered does not exist. Check and try again');
        }


    }
}
