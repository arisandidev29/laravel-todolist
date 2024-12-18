<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        DB::delete("delete from users");
        $this->seed(UserSeeder::class);
    }
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "arisandi@gmail.com",
            "password" => "arisanditest"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "arisandi@gmail.com");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }

    public function testRegister() {
        $this->post('/register', [
            'name' => 'nandi',
            'email' => 'nandi@gmail.com',
            'password' => 'nandi123@',
            'password-confirm' => 'nandi123@'
        ])->assertRedirect('/login');


    }

}
