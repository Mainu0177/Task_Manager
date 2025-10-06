<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\Group\GroupStoreRequest;
use App\Http\Requests\API\V1\Group\GroupUpdateRequest;
use App\Models\Group;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index(Request $request){
        $perPage = min(100, (int) $request->get('per_page', 20));

        $query = Group::query();

        $group = $query->latest('created_at')->paginate($perPage);

        return $this->success($group, 'Group Data');
    }

    public function store(GroupStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $group = Group::create($data);
            return $this->success($group, 'Group store success');
        } catch (\Exception $exception) {
            Log::error('Group store Error : ' .$exception->getMessage());
        }
    }

//     public function store(GroupStoreRequest $request)
// {
//     $data = $request->validated();

//     // If you mean "who created this group", use the user id:
//     // $data['created_by'] = auth()->id(); // or $request->user()->id

//     try {

//         $group = Group::create($data);
//         return response()->json([
//             'message' => 'Group created successfully',
//             'data' => $group
//         ], 201);
//     } catch (\Throwable $e) {
//         Log::error('Group store error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

//         return response()->json([
//             'message' => 'Failed to create group'
//         ], 500);
//     }
// }


    public function update(GroupUpdateRequest $request, Group $group)
    {
        // dd($request->validated()['name']);
        try {
            $data = $request->validated();
            $group->update($data);
            return $this->success($group, 'Task updated');
        } catch (\Exception $exception) {
            Log::error('Task update Error : ' .$exception->getMessage());
        }
    }

    public function destroy(Group $group)
    {
        try {
            $group->delete();
            return $this->success('', 'Group Deleted successfully');
        } catch (\Exception $exception) {
            Log::error('Group delete Error : ' .$exception->getMessage());
        }
    }
}
