<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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
        $request->authenticate();

        $request->session()->regenerate();

        // Catat aktivitas login ke audit log
        AuditLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'LOGIN',
            'description' => 'Login ke sistem oleh ' . Auth::user()->name
                             . ' (' . Auth::user()->role . ')'
                             . ' dari IP ' . $request->ip(),
            'timestamp'   => now(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Catat aktivitas logout sebelum session dihapus
        if (Auth::check()) {
            AuditLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'LOGOUT',
                'description' => 'Logout dari sistem oleh ' . Auth::user()->name,
                'timestamp'   => now(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
