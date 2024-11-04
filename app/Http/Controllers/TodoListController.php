<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


    namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{
    // List all to-do lists for the authenticated user
    public function index()
    {
        $todoLists = Auth::user()->todoLists;
        return response()->json($todoLists);
    }

    // Show a specific to-do list by ID
    public function show($id)
    {
        $todoList = Auth::user()->todoLists()->find($id);

        if (!$todoList) {
            return response()->json(['message' => 'To-Do List not found'], 404);
        }

        return response()->json($todoList);
    }

    // Create a new to-do list
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $todoList = Auth::user()->todoLists()->create([
            'name' => $request->name
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        return response()->json($todoList, 201);
    }

    // Update a to-do list’s name
    public function update(Request $request, $id)
    {
        $todoList = Auth::user()->todoLists()->find($id);

        if (!$todoList) {
            return response()->json(['message' => 'To-Do List not found'], 404);
        }

        $request->validate(['name' => 'required|string|max:255']);
        $todoList->update(['name' => $request->name]);

        return response()->json($todoList);
    }

    // Delete a to-do list
    public function destroy($id)
    {
        $todoList = Auth::user()->todoLists()->find($id);

        if (!$todoList) {
            return response()->json(['message' => 'To-Do List not found'], 404);
        }

        $todoList->delete();

        return response()->json(['message' => 'To-Do List deleted successfully']);
    }
}

