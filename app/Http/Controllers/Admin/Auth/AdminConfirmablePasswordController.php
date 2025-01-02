<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('admin.auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('admin')->validate([
            'email' => $request->admin()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('admin.auth.password'),
            ]);
        }

        $request->session()->put('admin.auth.password_confirmed_at', time());

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }
}