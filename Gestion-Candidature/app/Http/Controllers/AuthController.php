<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Competence;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'competences' => 'nullable|array', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($request->has('competences')) {
            $competences = [];
            foreach ($request->competences as $competenceName) {
                $competences[] = Competence::firstOrCreate(['name' => $competenceName])->id;
            }
            $user->competences()->sync($competences);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user->load('competences'),
            'token' => $token
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les informations de connexion sont incorrectes.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user->load('competences'),
            'token' => $token
        ], 200);
    }
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => "sometimes|string|email|max:255|unique:users,email,{$user->id}",
            'password' => 'sometimes|string|min:6',
            'competences' => 'nullable|array',
            'competences.*' => 'string|max:255',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        if ($request->has('competences')) {
            $competences = [];
            foreach ($request->competences as $competenceName) {
                $competences[] = Competence::firstOrCreate(['name' => $competenceName])->id;
            }
            $user->competences()->sync($competences);
        }
        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'user' => $user->load('competences'),
        ], 200);
    }
}
