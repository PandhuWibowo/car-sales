<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class AuthController extends Controller
{
    public function signin() {
        return view('signin.index');
    }

    public function check(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('LoggedUser', $user->id);
                return redirect('products');
            } else {
                return back()->with('failed', 'Invalid Password');
            }
        } else {
            return back()->with('failed', 'No account found for this email');
        }
    }

    public function signout(Request $request) {
        $request->session()->forget('LoggedUser');

        $request->session()->flush();
        return redirect('signin');
    }
}
