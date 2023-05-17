<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\MyHelper\makeMessage;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function show()
    {
        return view('formulario');
    }


    public function store(Request $request)
    {

        require_once('D:\Proyectos\ProyectoMelody\app\Helpers\MyHelper.php');

        $messages = makeMessages();
        // Validación
        $this->validate($request, [
            'name_user' => ['required', 'min:3','regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8','regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\dñÑ]+$/']
        ], $messages);
        //'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\dñÑ]+$/]
        // Crear al usuario
        User::create([
            'name' => $request->name_user,
            'email' => Str::lower($request->email),
            'password' => Hash::make($request->password),
            'role' => 1
        ]);

        // Autenticar al usuario
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Redireccionar al usuario
        return view('layouts.dashboard');
    }
}
