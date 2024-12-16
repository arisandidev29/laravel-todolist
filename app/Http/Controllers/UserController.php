<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('email');
        $password = $request->input('password');

        // validate data
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($this->userService->login($user, $password)) {
            $request->session()->regenerate();
            return redirect("/todolist");
        }

        return back()->withErrors([
            'message' => 'email or password wrong '
        ])->onlyInput('email');

    }


    public function register() {
        return view('user.register');
    }

    public function doRegister(Request $request) {
        $validated = $request->validate([
        'username' => 'required',
        'email' => 'required|unique:users,email',
        'password' => Password::min(8)->letters()->numbers(),
        'password-confirm' => 'required|same:password'
       ]);

    //    dd($validated);


       if($this->userService->register($validated)) {
            return redirect('/login')->with('message','success create account, please login');    
       }


    }

    public function doLogout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
