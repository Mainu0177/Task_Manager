<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function profile(Request $request){
        try {
            return $this->success(new UserResource($request->user()), 'User Profile Retrieved Successfully');
        } catch (\Exception $exception) {
            Log::error('RegisterRequest Error : ' .$exception->getMessage());
            return $this->error(['Something went wrong'], 500);
        }
    }

    public function update(ProfileUpdateRequest $request){
        try {
            $user = $request->user();
            $user->update($request->validated());
            return $this->success(new UserResource($user), 'Profile Updated Successfully');
        } catch (\Exception $exception) {
            Log::error('RegisterRequest Error : ' .$exception->getMessage());
            return $this->error(['Something went wrong'], 500);
        }
    }
}
