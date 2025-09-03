<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function taskList()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Create new task
    public function create(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'status' => 'required|in:pending,completed'
        // ]);
        $user = Auth::user();

        $task = Task::create([
            'user_id' => $user->id,
            'title' =>  $request->title,
            'description' =>  $request->description,
            'status' =>  $request->status,
        ]);

        //Now Send Notification To Login user
     $user = $request->user();
     $user->notify(new TaskCreatedNotification($task));

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    // Update an existing task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed'
        ]);

        $task->update($request->all());

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }


    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete(); // Soft delete

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
