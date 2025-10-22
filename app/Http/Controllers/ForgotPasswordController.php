<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetPasswordMail;

class ForgotPasswordController extends Controller
{
    /**
     * Form Email
     *
    */
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Proses Reset Password
     *
    */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem admin.']);
        }

        // Generate token unik
        $token = Str::random(64);

        // Simpan token ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $admin->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Kirim email berisi link reset
        Mail::to($admin->email)->send(new AdminResetPasswordMail($token));

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }
}


