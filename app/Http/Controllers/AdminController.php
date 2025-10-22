<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Event;
use App\Models\PartnerList;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('username'));
        }

        $credentials = $validator->validated();

        $admin = Admin::where('username', $credentials['username'])->first();
        
        if (! $admin) {
            throw ValidationException::withMessages([
                'username' => ['Username yang diinput salah.'],
            ])->redirectTo(route('login'));
        }

        if ($admin) {
            $storedPassword = (string) $admin->password;
            $inputPassword  = (string) $credentials['password'];

            $isBcrypt = Str::startsWith($storedPassword, ['$2y$', '$2a$', '$2b$']) && strlen($storedPassword) >= 59;

            if ($isBcrypt) {
                if (Auth::guard('admin')->attempt([
                    'username' => $credentials['username'],
                    'password' => $inputPassword,
                ])) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                }
            } else {
                if (hash_equals($storedPassword, $inputPassword)) {
                    $admin->password = Hash::make($inputPassword);
                    $admin->save();

                    Auth::guard('admin')->login($admin);
                    $request->session()->regenerate();

                    return redirect()->intended(route('admin.dashboard'));
                }
            } 
        }

        throw ValidationException::withMessages([
            'password' => ['Password yang diinput salah.'],
        ])->redirectTo(route('login'));
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Dashboard / Home admin
     */
    public function home()
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $jumlahProduk   = Product::count(); // hitung jumlah produk
        $lokasiMitra    = PartnerList::count(); 
        $event          = Event::count();
        $artikel        = Article::count();
        
        return view('admin.home', compact('jumlahProduk', 'lokasiMitra', 'event', 'artikel'));
    }

    /**
     * List semua admin
     */
    public function daftaradmin()
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $admins = Admin::with('role')->get();
        $roles  = Role::all();

        return view('admin.read.admin-list', compact('admins', 'roles'));
    }

    /**
     * Store admin baru
     */
    public function store(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admin,email',
            'role_id'  => 'required|exists:roles,id',
        ]);

        Admin::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->username),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('admin.list')->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username,' . $admin->id,
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admin,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $data = [
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.list')->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Hapus admin
     */
    public function destroy($id)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.list')->with('success', 'Admin berhasil dihapus!');
    }   
}
