<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
         return view('pages.login');
    }

    public function processLogin(LoginRequest $request) {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->intended();
        }
 
        return back()->withErrors([
            'failed' => 'Password is incorrect',
        ])->onlyInput('username');
        // return redirect()->route('home');
   }

   public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index');
    }
}
