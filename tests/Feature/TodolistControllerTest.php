<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
       DB::delete("delete from todos");
       DB::delete("delete from users");

    }
    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);
        $this->withSession([
            "user" => "arisandi@gmai.com",
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("arisandi");
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


}
