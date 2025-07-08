<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    try {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    } catch (ValidationException $e) {
        return redirect()->route('login')->withErrors($e->errors())->withInput();
    }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.confirmed' => 'A confirmação da senha não confere.',
            'new_password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ];

        $rules = [
            'id' => 'required|exists:users,id',
            'new_password' => [
                'required',
                'string',
                'min:6',
            ]
        ];

        $request->validate($rules, $messages);

        $user = \App\Models\User::findOrFail($request->id);
        $user->password = $request->new_password;
        $user->save();

        return response()->json(['success' => true]);
    }

    
}
