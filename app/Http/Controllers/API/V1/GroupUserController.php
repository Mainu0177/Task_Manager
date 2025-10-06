<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\Group\GroupUserRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GroupUserController extends Controller
{
    public function store(GroupUserRequest $request, Group $group){
        try {
            $data = $request->validated();
            
        } catch (\Exception $exception) {
            Log::error('Group store Error : ' .$exception->getMessage());
        }
    }
}
