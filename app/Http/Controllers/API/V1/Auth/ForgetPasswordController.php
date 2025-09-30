<?php

namespace App\Http\Controllers\API\V1\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\V1\Auth\ResetPasswordRequest;
use App\Http\Requests\API\V1\Auth\ForgetPasswordRequest;
use App\Http\Requests\API\V1\Auth\ForgetPasswordVerifyOtpRequest;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordSendOtp(ForgetPasswordRequest $request){
        try {
            $otp = rand(100000, 999999);
            PasswordResetOtp::updateOrCreate([
                'email' => $request->email,
            ],[
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            Mail::raw("Your Password reset OTP is $otp. OTP expires in 10 minutes", function ($message) use ($request) {
                $message->to($request->email)->subject("Password Reset OTP");
            });

            return $this->success([], 'Password reset OTP sent to your email');
        } catch (\Exception $exception) {
            Log::error('Reset Password Otp send Error : ' .$exception->getMessage());
            return $this->error(['Something went wrong'], 500);
        }
}
    public function verifyOtp(ForgetPasswordVerifyOtpRequest $request){
        try {
            $record = PasswordResetOtp::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

                if(!$record){
                return $this->error(['Invalid OTP given'], 422);
                }
                if(Carbon::parse($record->expires_at)->isPast()){
                return $this->error(['Invalid OTP expired'], 422);
                }
            return $this->success(['OTP verified']);
        } catch (\Exception $exception) {
            Log::error('RegisterRequest Error : ' .$exception->getMessage());
            return $this->error(['Something went wrong'], 500);
        }

}
    public function resetPassword(ResetPasswordRequest $request){
        try {
            $record = PasswordResetOtp::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

                if(!$record){
                return $this->error(['Invalid OTP given'], 422);
                }
                if(Carbon::parse($record->expires_at)->isPast()){
                return $this->error(['Invalid OTP expired'], 422);
                }

            $user = User::where('email', $request->email)->first();
            $user->password = $request->password;
            $user->save();

            $record->delete();

            return $this->success('Password reset successfully');

        } catch (\Exception $exception) {
            Log::error('Password reset error : ' .$exception->getMessage());
            return $this->error(['Something went wrong'], 500);
        }
}
}
