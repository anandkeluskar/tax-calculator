<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }
    
    public function index(){
        return view('auth.register');
    }

    public function register_user(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|min:2',
            'email' => 'required|max:255|email',
            'password' => 'required|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        auth()->attempt($request->only('email','password'));

        return redirect()->route('dashboard');
    }
}
