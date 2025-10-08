<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Group\GroupUserRequest;

class GroupUserController extends Controller
{
    public function list(Request $request, Group $group){
        $perPage = min(100, (int) $request->get('per_page', 20));
        $groupUsers = $group->users()->paginate($perPage);
        return $this->success($groupUsers, 'Group users List');
    }
    public function store(GroupUserRequest $request, Group $group){
        // $all = $request->all();
        // print 'pre';
        // print_r($all);
        // print 'pre';
        try {
            $validatedData = $request->validated();
            $ids = collect($validatedData['user_ids'] ?? []);

            if(!empty($validatedData['user_id'])){
                $ids->push($validatedData['user_id']);
            }

            $ids = $ids->unique()->values()->all();

            $group->users()->syncWithoutDetaching($ids);

            $groupUserData = $group->users()->select('users.id', 'users.name', 'users.email')->get();

            return $this->success($groupUserData, 'Store Success');

        } catch (\Exception $exception) {
            Log::error('Group store Error : ' .$exception->getMessage());
        }
    }

    public function destroy(Group $group, User $user){
        try {
            $group->users()->detach($user->id);
            return $this->success('', 'Group user Deleted');
        } catch (\Exception $exception) {
            Log::error('Group user deleted Error : ' .$exception->getMessage());
        }
    }
}
