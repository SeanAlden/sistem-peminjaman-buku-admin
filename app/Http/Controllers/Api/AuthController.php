<?php

namespace App\Http\Controllers\API;

use Psy\Util\Str;
use App\Models\User;
use App\Rules\ReChaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi untuk mendaftarkan atau membuat akun baru
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|max:255',
    //         'email' => 'required|unique:users,email|max:255|email',
    //         'phone' => 'required|string|max:20',
    //         'password' => 'required|string|confirmed|min:5|max:255'
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'password' => bcrypt($request->password),
    //         'usertype' => 'user' // default value
    //     ]);
    //     $token = $user->createToken('auth_token')->plainTextToken;
    //     $reesponse = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($reesponse, 201);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|confirmed|min:5|max:255'
        ]);

        // Cek apakah email ada di tabel students
        $isStudent = DB::table('students')->where('email', $request->email)->exists();

        if (!$isStudent) {
            return response()->json([
                'message' => 'Anda tidak dapat register karena belum terdaftar pada situs peminjaman buku ini.'
            ], 403); // 403 Forbidden
        }

        // Cek email unik pada users
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email sudah digunakan.'
            ], 409); // 409 Conflict
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'usertype' => 'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Fungsi untuk melakukan login
    // public function signin(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::where('email', $request->email)->first();
    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response([
    //             'message' => 'Kredensial login salah'
    //         ], 401);
    //     }
    //     $token = $user->createToken('auth_token')->plainTextToken;
    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($response, 201);
    // }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password sesuai
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Kredensial login salah'
            ], 401);
        }

        // Cek apakah usertype adalah 'admin'
        if ($user->usertype === 'admin') {
            return response([
                'message' => 'Login hanya diizinkan untuk user biasa'
            ], 403);
        }

        // Jika lolos, generate token dan return response
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    // Fungsi untuk melakukan logout
    public function destroy(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'status' => 201,
            'message' => 'Logged Out'
        ];
    }

    // Fungsi untuk mengupdate data profil
    public function updateProfile(Request $request)
    {
        // /**
        //  * @var \App\Models\User $user
        //  */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }

    // Fungsi untuk mengupdate data password
    public function updatePassword(Request $request)
    {
        // /**
        //  * @var \App\Models\User $user
        //  */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }

    // Fungsi untuk mengupdate gambar profil
    public function updateProfileImage(Request $request)
    {
        // /**
        //  * @var \App\Models\User $user
        //  */
        // // $user = auth()->user();
        $user = Auth::user();

        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            // Hapus gambar lama jika ada
            if ($user->profile_image) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }

            $image = $request->file('profile_image');
            $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $filename, 'public');

            $user->profile_image = $filename;
            $user->save();

            return response()->json([
                'message' => 'Profile image updated successfully',
                'profile_image' => $filename,
            ]);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }

    // Fungsi untuk mendapatkan data gambar profil
    public function getProfileImage(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'profile_image' => $user ? $user->profile_image : null,
        ], 200);
    }

    // public function uploadProfileImage(Request $request)
    // {
    //     /**
    //      * @var \App\Models\User $user
    //      */
    //     $user = Auth::user();

    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $path = $file->storeAs('public/profile_images', $filename);
    //         Log::info("Image stored at path: " . $path);

    //         $user->profile_image = $filename;
    //         // $user->profile_image = $path;
    //         $user->save();

    //         return response()->json(['message' => 'Image uploaded', 'filename' => $filename]);
    //     }

    //     return response()->json(['error' => 'No image uploaded'], 400);
    // }

    // public function getProfileImage(Request $request) 
    // {

    //     $user = Auth::user();

    //     if ($user && $user->profile_image) {
    //         return response()->json([
    //             'profile_image' => $user->profile_image,
    //         ]);
    //     }

    //     return response()->json([
    //         'profile_image' => null,
    //     ], 404);
    // }

    // Mengirim kode verifikasi ke email
    public function getVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $code = random_int(1000, 9999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $code,
                'created_at' => now()
            ]
        );

        // Kirim email ke user (simulasi)
        Mail::raw("Your reset code is: $code", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset Code');
        });

        return response()->json(['message' => 'Reset code sent to email.']);
    }

    // Melakukan verifikasi kode dari inputan user
    public function validateVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Invalid or expired code'], 400);
        }

        // Opsional: expired check (misal 15 menit)
        $expired = Carbon::parse($record->created_at)->addMinutes(15);
        if (now()->greaterThan($expired)) {
            return response()->json(['message' => 'Code expired'], 400);
        }

        return response()->json(['message' => 'Code verified']);
    }

    // Fungsi untuk menyimpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Hapus kode verifikasi dari tabel
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password has been reset']);
    }

    // // Menampilkan semua user
    // public function showAllUser()
    // {
    //     $users = User::all();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All users retrieved successfully',
    //         'data' => $users
    //     ]);
    // }

    // // Menampilkan user berdasarkan ID
    // public function showUserById($id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User retrieved successfully',
    //         'data' => $user
    //     ]);
    // }

    // Menampilkan semua user
    public function showAllUser()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'message' => 'All users retrieved successfully',
            'data' => $users
        ]);
    }

    // Menampilkan user berdasarkan ID
    public function showUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }

    // Menampilkan user dengan usertype selain 'user' (misalnya admin)
    public function showNonUser()
    {
        $users = User::where('usertype', '!=', 'user')->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No non-user accounts found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Non-user accounts retrieved successfully',
            'data' => $users
        ]);
    }

}




