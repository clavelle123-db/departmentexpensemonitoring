<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to authenticate using the custom LoginRequest (username + password)
        $request->authenticate();

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Redirect to intended or default dashboard
        $user = Auth::user();
switch ($user->role) {
    case 'admin':
        return redirect()->route('admin.dashboard');
    case 'head':
        return redirect()->route('head.dashboard'); // <-- changed
    case 'user':
        return redirect()->route('user.dashboard');
    default:
        Auth::logout();
        return redirect()->route('login')->withErrors(['role' => 'Unauthorized role.']);
}



    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
