<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Option;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Return register form
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a new user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'username' => ['required', 'string', 'min:2', 'max:80'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:10', 'max:80'],
            'create_ingredients' => ['sometimes'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        addStartingOptionsToUser($user);

        if($request->create_ingredients){
            createBasicIngredientsForUser($user);
        }

        Auth::login($user);

        return redirect()->intended(route('front'));
    }

    /**
     * Return login form
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'remember' => ['sometimes'],
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = false;

        if($request->remember){
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended(route('front'));
        }

        return back()->withErrors([
            'email' => 'Email or Password is wrong',
        ]);
    }

    /**
     * Disconnect user and end session
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('guest');
    }
}
