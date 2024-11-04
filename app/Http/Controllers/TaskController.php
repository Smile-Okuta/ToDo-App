<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    // List tasks for a specific to-do list
    public function index($todoListId)
    {
        $todoList = Auth::user()->todoLists()->find($todoListId);

        if (!$todoList) {
            return response()->json(['message' => 'To-Do List not found'], 404);
        }

        return response()->json($todoList->tasks);
    }

    // Retrieve a specific task by ID
    public function show($todoListId, $taskId)
    {
        $task = Task::where('todo_list_id', $todoListId)->find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    // Add a task to a to-do list
    public function store(Request $request, $todoListId)
    {
        $request->validate([
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'in:pending,completed'
        ]);

        $todoList = Auth::user()->todoLists()->find($todoListId);

        if (!$todoList) {
            return response()->json(['message' => 'To-Do List not found'], 404);
        }

        $task = $todoList->tasks()->create($request->all());

        return response()->json($task, 201);
    }

    // Update task details
    public function update(Request $request, $todoListId, $taskId)
    {
        $task = Task::where('todo_list_id', $todoListId)->find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'description' => 'string',
            'due_date' => 'date',
            'status' => 'in:pending,completed'
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    // Soft delete a task
    public function destroy($todoListId, $taskId)
    {
        $task = Task::where('todo_list_id', $todoListId)->find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
