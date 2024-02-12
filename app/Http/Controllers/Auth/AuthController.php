<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::user()) {
            $route = $this->redirectDash();
            return redirect($route);
        }
        return view('auth.login');
    }

    public function redirectDash()
    {
        $redirect = '';

        if (Auth::user() && Auth::user()->role == 3) {
            $redirect = 'admin';
        } else if (Auth::user() && Auth::user()->role == 2) {
            $redirect = 'pengurus';
        } else if (Auth::user() && Auth::user()->role == 1) {
            $redirect = 'forum';
        } else {
            $redirect = 'forum';
        }

        return $redirect;
    }

    public function authenticate()
    {

        $validated = request()->validate([
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();

            $user = auth()->user();

            // Check the user's role and redirect accordingly
            switch ($user->role) {
                case 1:
                    return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
                    break;
                case 2:
                    return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
                    break;
                case 3:
                    return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
                    break;

                default:
                    return redirect()->route('home')->with('success', 'Logged in successfully!');
            }
        }

        $ldapResponse = Http::asForm()->post('https://developer.angkasapura2.co.id/mobile/ldap/is_valid/', [
            'username' => $validated['username'],
            'password' => $validated['password'],
        ]);

        $ldapData = $ldapResponse->json();

        if ($ldapResponse->successful() && $ldapData['status'] === 'ok') {
            $user = User::where('username', $validated['username'])->first();

            if (!$user) {
                $userData = [
                    'username' => $ldapData['username'],
                    'name' => $ldapData['name'],
                    'password' => Hash::make($validated['password']),
                    'email' => $ldapData['personal_email'],
                    'nip' => $ldapData['nip'],
                    'unit' => $ldapData['unit_name'],
                    'role' => '1',
                    'is_ldap' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                User::create($userData);
            }

            $user = User::where('username', $validated['username'])->first();

            auth()->loginUsingId($user->id);

            request()->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }

        return redirect()->route('login')->withErrors([
            'username' => 'No matching user found with the provided username and password'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('dashboard')->with('success, Logged out successfulyy!');
    }
}
