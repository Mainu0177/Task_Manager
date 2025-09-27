<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        try {
            $user = User::create($request->validated());
            return $this->success(new UserResource($user), 'User Registered Successfully');
        } catch (\Exception $exception) {
            Log::error('RegisterRequest Error : ' .$exception->getMessage());
        }
    }

    public function login(LoginRequest $request){
        try {
            $user = User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password)){
                return $this->error(['Invalid Credentials'], 422);
            }

            $authToken = $user->createToken('authToken')->plainTextToken;
            $data = [
                'user' => new UserResource($user),
                'token' => $authToken,
            ];

            return $this->success($data, 'User Logged In Successfully');
        } catch (\Exception $exception) {
            Log::error('RegisterRequest Error : ' .$exception->getMessage());
        }
    }
}
