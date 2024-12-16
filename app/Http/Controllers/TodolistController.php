<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view("todolist.index", [
            "title" => "Todolist",
            "todolist" => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input("todo");

        $validated = $request->validate([
            'todo' => 'required|min:10'
        ]);


        $this->todolistService->saveTodo($validated['todo']);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function editTodo(string $id, Request $request) {
        $validated = $request->validate([
            'todo' => 'required'
        ]);

        // dd($id);

        $this->todolistService->editTodo($id,$validated['todo']);

        return back()->with('message','success update todo');
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return back()->with('message', 'success delete todo');
    }
}
