<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = Task::createNewTask($request->all());

        return response()->json(['success' => 'Task created', 'task' => $task], 201);
    }

    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function update(Request $request, string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $completed = isset($request->completed) ? (bool) $request->completed : false;
        $completedAt = $completed ? now() : null;

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => isset($request->file) ? $request->file->storeAs('attach', $request->file->getClientOriginalName()) : null,
            'completed' => $completed,
            'completed_at' => $completedAt,
            'user_id' => isset($request->user_id) ? $request->user_id : auth()->id(),
        ]);
        return response()->json($task);
    }

    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted'], 204);
    }
}
