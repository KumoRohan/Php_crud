<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;

// class AuthController extends Controller
// {
//     //\\
//     public function register(Request $request) {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//         ]);
//     }

//     public function login(Request $request) {
//         $request->validate([
//             'email' => 'required|string|email',
//             'password' => 'required|string',
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if (! $user || ! Hash::check($request->password, $user->password)) {
//             throw ValidationException::withMessages([
//                 'email' => ['The provided credentials are incorrect.'],
//             ]);
//         }

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//         ]);
//     }

//     public function logout(Request $request) {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json([
//             'message' => 'Successfully logged out',
//         ]);
//     }

//     public function user(Request $request) {
//         return response()->json($request->user());
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Register user
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Check if request expects JSON (API) or web response
        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Web authentication - login the user
        //Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    // Login user
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // API request
            if ($request->expectsJson()) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Web request
            return back()->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ])->withInput($request->only('email'));
        }

        // Check if request expects JSON (API) or web response
        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Web authentication
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('products.index'))->with('success', 'Login successful!');
    }

    // Logout user
    public function logout(Request $request) 
    {
        // API logout
        if ($request->expectsJson() && $request->user()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }

        // Web logout
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    // Get authenticated user
    public function user(Request $request) 
    {
        return response()->json($request->user());
    }
}