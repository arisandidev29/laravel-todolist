<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from todos");
        DB::delete("delete from users");
    }
    public function testTodolist()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::where('name', 'arisandi')->first();
        Auth::login($user);

        $this->get('/todolist')
            ->assertSeeText('arisandi');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post("/todolist", [
            "todo" => "Eko"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->seed(TodoSeeder::class);
        $this->withSession([
            "user" => "khannedy",

        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }

    public function testEditTodo()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::where('name', 'arisandi')->first();
        Auth::login($user);

        $id = Auth::user()->todos->first()->id;
        $this->post("/todolist/$id/edit", [
            'todo' => 'hello'
        ])->assertSeeText('success update todo');

        dump(Todo::find($id));
    }
}
