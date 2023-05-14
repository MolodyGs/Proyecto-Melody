<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {

        return view('auth.login');
    }

    public function dashboard()
    {
        // Retornar al dashboard

        return view('login');  
    }

    public function loginAuth(Request $request)
    {
        $messages = makeMessages();
        // Validar la información
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ], $messages);

        if(!auth()->attempt($request->only('email', 'password'), $request->remember))
        {
            return redirect()->route('login')->with("error",'Correo o contraseña incorrecto');
        }



        return redirect()->route('dashboard');
    }

}
