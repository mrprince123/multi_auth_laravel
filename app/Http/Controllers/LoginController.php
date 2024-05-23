<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }


    public function authLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('employee.dashboard');
            } else {
                return redirect()->route('employee.login')->with('error', 'Invalid Credentials');
            }
        } else {
            return redirect()->route('employee.login')
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function register()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->passes()) {

            $user  = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role = 'employee';
            $user->save();

            return redirect()->route('employee.login')->with('success', 'Employee Registered Successfully');
        } else {
            return redirect()->route('employee.register')
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('employee.login');
    }
}
