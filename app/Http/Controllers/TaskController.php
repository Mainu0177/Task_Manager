<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\V1\Task\TaskUpdateRequest;
use App\Models\Task;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\API\V1\Task\TaskStoreRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(100, (int) $request->get('per_page', 20));

        $query = Task::query();

        $task = $query->latest('created_at')->paginate($perPage);

        return $this->success($task, 'Task Data');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $task = Task::create([
                'created_by' => $request->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ?? 'created'
            ]);
            return $this->success($task, 'Task store success');
        } catch (\Exception $exception) {
            Log::error('Task store Error : ' .$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        try {
            $data = $request->validated();
            $task->fill($data)->save();

            return $this->success($task, 'Task updated');
        } catch (\Exception $exception) {
            Log::error('Task update Error : ' .$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return $this->success('', 'Task Deleted successfully');
        } catch (\Exception $exception) {
            Log::error('Task delete Error : ' .$exception->getMessage());
        }
    }
}
