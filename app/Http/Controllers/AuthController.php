<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
class AuthController extends Controller
{


    function register(RegisterRequest $request)
    {
        $validated = $request->validated();
    
        // Verificar si el email ya existe
        if (User::where('email', $validated['email'])->exists()) {
            return response()->json([
                'message' => 'El correo electrónico ya está registrado.',
            ], 409); // 409 Conflict
        }
    
        // Crear usuario y generar token
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        $token = $user->createToken('api-Carrito')->plainTextToken;
        session(['api_token' => $token]);
        return response()->json([
            'message' => 'Registro exitoso',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }
    
        
        function login(LoginRequest $request){
         
        $validated = $request->validated();
        if(Auth::attempt($validated)) {
        $user = Auth::user();
        $token = $user->createToken('api-Carrito')->plainTextToken;
        session(['api_token' => $token]);
        return response()->json([
        'message' => 'Login successful',
        'data' => [
        'user' => $user,
        'token' => $token
        ]
        ],200);
        }else{
        return response()->json([
        'message' => 'Login failed',
        'data' => []
        ],401);
        }
        
        }
        public function logout(Request $request)
        
        {
        
            $request->user()->currentAccessToken()->delete();
        
            return response()->json(['message' => 'Logged out']);
        
        }
}
