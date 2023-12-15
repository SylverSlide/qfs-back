<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function user()
    {
        return response()->json(['user' => Auth::user()]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'firstname' => $data['firstname'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verification_token' => Str::uuid(),
        ]);
        $verificationUrl = config('app.frontend_url') . '/verify-email/' . $user->email_verification_token;
        Mail::send('emails.confirmation_mail', ['verificationUrl' => $verificationUrl, 'firstname' => $data['firstname']], function ($message) use ($data) {
            $message->to($data['email'])->subject('Verification adresse mail');
        });

        return response()->json(['message' => 'Veuillez vérifier votre adresse e-mail pour confirmer votre compte ! token =>' . $user->email_verification_token], 201);
    }

    public function verifyEmail($token)
    {
        // Trouvez l'utilisateur avec le token de vérification
        $user = User::where('email_verification_token', $token)->firstOrFail();

        // Vérifiez si l'e-mail a déjà été vérifié
        if ($user->email_verified_at) {
            // Rediriger l'utilisateur vers une page indiquant que l'e-mail a déjà été vérifié
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        // Validez l'e-mail de l'utilisateur
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully!'], 200);
    }

    public function login(Request $request)
    {
        // Validez les données entrantes
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Vérifiez les informations d'identification de l'utilisateur
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials!'], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Email not verified!'], 401);
        }

        // Si elles sont correctes, créez un token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // Retournez le token dans la réponse
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }


    public function logout()
    {
        if (Auth::check()) {
            // Révoquer le token d'authentification de l'utilisateur
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $user->tokens()->delete();
        }

        // Retourner une réponse de déconnexion réussie
        return response()->json(['message' => 'Logged out successfully!'], 200);
    }
}
