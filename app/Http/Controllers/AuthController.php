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
            'email.required' => 'We need to know your email address!',
            'validation.confirmed' => 'teste',
            'validation.regex' => 'teste 2'
        ];

        $rules = [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ]
        ];

        $request->validate($rules,$messages);

        $user = $request->user();

        // Verifica se a senha atual confere
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'A senha atual está incorreta.'
            ]);
        }

        $user->password = $request->new_password;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Senha alterada com sucesso!');
    }

    
}
