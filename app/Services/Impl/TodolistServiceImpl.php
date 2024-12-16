<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{

    public function saveTodo(string $todo): void
    {
       $todo = new Todo([
        'todo' => $todo,
        'user_id' => Auth::user()->id
       ]);
       $todo->save();
    }

    public function getTodolist()   : array 
    {
        return Auth::user()->todos()->get()->toArray();
    }

    public function editTodo(string $id, string $todo): void {
        $todos = Todo::find($id);
        $todos->todo = $todo;
        $todos->save();
    }


    public function removeTodo(string $todoId)
    {
        $todo = Todo::find($todoId);
        $todo->delete();
        
        
    }
}
