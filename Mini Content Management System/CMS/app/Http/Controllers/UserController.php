<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function login(Request $request){
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required' 
        ]);

        if (auth()->attempt(['name' => $incomingFields['username'], 'password'=> $incomingFields['password']])) {
            $request->session()->regenerate();

            return redirect('/');
        } else {
            return redirect('/error');;
        } 
    }

    public function createUser(Request $request) {
        $incomingFields = $request->validate([
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }
}
