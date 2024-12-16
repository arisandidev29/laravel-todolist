<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use App\Services\TodolistService;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{

    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from todos');
        DB::delete('delete from users');
        $this->todolistService = $this->app->make(TodolistService::class);
    }


    public function testGetTodolistCurrentUser()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::where('name', 'arisandi')->first();

        Auth::login($user);

        $todo = $this->todolistService->getTodolist();
        self::assertEquals(2,count($todo));
    }




    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::where('name','arisandi')->first();
        Auth::login($user);


        $this->todolistService->saveTodo("3", "nandi");

        $todolist = $this->todolistService->getTodolist();
        dump($todolist);
        self::assertEquals(3, count($todolist));
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Eko",
            ],
            [
                "id" => "2",
                "todo" => "Kurniawan"
            ]
        ];

        $this->todolistService->saveTodo("1", "Eko");
        $this->todolistService->saveTodo("2", "Kurniawan");

        Assert::assertArraySubset($expected, $this->todolistService->getTodolist());

        // self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $todo = Todo::where('todo','arisandi')->first();


        $this->todolistService->removeTodo($todo->id);

        self::assertEquals(1, count(Todo::all()));
   }

   public function testEditTodo() {

    $this->seed([UserSeeder::class, TodoSeeder::class]);
    $id = Todo::first()->id;

    $this->todolistService->editTodo($id,'hello');


   }
}
