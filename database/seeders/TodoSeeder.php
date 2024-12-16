<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('name','arisandi')->first();
        $todo = new Todo();
        $todo->todo = 'arisandi';
        $todo->user_id = $user->id;
        $todo->save();

        $todo = new Todo();
        $todo->todo = 'sandi';
        $todo->user_id = $user->id;
        $todo->save();
    }
}
