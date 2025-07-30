<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        // $userId = $request->user()->id;
        $user = Auth::user();
        $favorites = Favorite::with('book')->where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'data' => $favorites->map(function ($fav) {
                return $fav->book;
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        // $userId = $request->user()->id;
        $user = Auth::user();

        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'book_id' => $request->book_id
        ]);

        return response()->json(['success' => true, 'message' => 'Buku ditambahkan ke favorit']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        Favorite::where('user_id', $request->user()->id)
            ->where('book_id', $request->book_id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Buku dihapus dari favorit']);
    }
}