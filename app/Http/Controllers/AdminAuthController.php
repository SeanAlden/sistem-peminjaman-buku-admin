<?php

namespace App\Http\Controllers;

use Str;
use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('usertype', 'admin')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Kredensial salah atau Anda bukan admin.',
            ]);
        }

        Auth::login($user);
        return redirect()->intended('/admin/dashboard');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|confirmed|min:5|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'usertype' => 'admin',
        ]);

        Auth::login($user);
        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('auth.profile_page', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }

            $image = $request->file('profile_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $filename, 'public');
            $user->profile_image = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        return view('auth.password_page');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.password')->with('success', 'Password berhasil diperbarui.');
    }

    // Menampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $code = random_int(1000, 9999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => now()]
        );

        Mail::raw("Kode reset password Anda: $code", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Kode Reset Password');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('verify.code')->with('success', 'Kode verifikasi telah dikirim ke email.');
    }

    public function showVerificationForm()
    {
        return view('auth.verification');
    }

    public function submitVerificationCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $email = session('reset_email');

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Kode salah atau kadaluarsa.']);
        }

        $expired = Carbon::parse($record->created_at)->addMinutes(15);
        if (now()->greaterThan($expired)) {
            return back()->withErrors(['code' => 'Kode telah kadaluarsa.']);
        }

        session(['verified_email' => $email]);

        return redirect()->route('reset.password');
    }

    public function showResetPasswordForm()
    {
        return view('auth.new_password');
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $email = session('verified_email');

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();
        session()->forget(['reset_email', 'verified_email']);

        return redirect('/admin/login')->with('success', 'Password berhasil diubah.');
    }

}
