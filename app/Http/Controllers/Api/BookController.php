<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     foreach ($books as $book) {
    //         $book->image_url = asset('storage/' . $book->image_url);

    //         if ($user) {
    //             $book->is_borrowed = Loan::where('user_id', $user->id)
    //                 ->where('book_id', $book->id)
    //                 ->where('status', 'borrowed')
    //                 ->exists();
    //         } else {
    //             $book->is_borrowed = false;
    //         }
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $reservedBookIds = [];

    //     // Jika user login, ambil ID buku yang sedang mereka reservasi
    //     if ($user) {
    //         $reservedBookIds = Reservation::where('user_id', $user->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->pluck('book_id') // Ambil hanya kolom book_id
    //             ->toArray(); // Konversi menjadi array
    //     }

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     // Tambahkan atribut custom ke setiap buku
    //     $books->map(function ($book) use ($user, $reservedBookIds) {
    //         // Menambahkan URL gambar yang lengkap
    //         $book->image_url = $book->image_url ? asset('storage/' . $book->image_url) : null;

    //         // Tambahkan flag is_reserved_by_user
    //         $book->is_reserved_by_user = in_array($book->id, $reservedBookIds);

    //         return $book;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $reservedBookIds = [];

    //     // Jika user login, ambil ID buku yang sedang mereka reservasi
    //     if ($user) {
    //         $reservedBookIds = Reservation::where('user_id', $user->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->pluck('book_id') // Ambil hanya kolom book_id
    //             ->toArray(); // Konversi menjadi array
    //     }

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     // Tambahkan atribut custom ke setiap buku
    //     $books->map(function ($book) use ($user, $reservedBookIds) {
    //         // Menambahkan URL gambar yang lengkap
    //         // $book->image_url = $book->image_url ? asset('storage/' . $book->image_url) : null;
    //         $book->image_url = $book->image_url ? asset('storage/' . $book->image_url) : null;

    //         // Tambahkan flag is_reserved_by_user
    //         $book->is_reserved_by_user = in_array($book->id, $reservedBookIds);

    //         return $book;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $reservedBookIds = [];

    //     if ($user) {
    //         $reservedBookIds = Reservation::where('user_id', $user->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->pluck('book_id')
    //             ->toArray();
    //     }

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     $books->map(function ($book) use ($reservedBookIds) {

    //         // ✅ URL lengkap dari S3
    //         $book->image_url = $book->image_url
    //             // ? Storage::disk('s3')->url('book_images/' . $book->image_url)
    //             ? Storage::disk('s3')->url($book->image_url)
    //             : null;

    //         // Flag reserved
    //         $book->is_reserved_by_user = in_array($book->id, $reservedBookIds);

    //         return $book;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();

    //     // Ambil reserved book IDs (jadi set, bukan array biasa)
    //     $reservedBookIds = collect();

    //     if ($user) {
    //         $reservedBookIds = Reservation::where('user_id', $user->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->pluck('book_id')
    //             ->flip(); // lookup O(1)
    //     }

    //     $books = Book::query()
    //         ->where('status', 'active')
    //         ->select([
    //             'id',
    //             'title',
    //             'image_url',
    //             'author',
    //             'stock',
    //             'description',
    //             'loan_duration',
    //             'status',
    //             'category_id',
    //             'created_at',
    //             'updated_at',
    //         ])
    //         ->with('category')
    //         ->get()
    //         ->map(function ($book) use ($reservedBookIds) {

    //             // URL S3 (aman & cepat)
    //             $book->image_url = $book->image_url
    //                 ? Storage::disk('s3')->url($book->image_url)
    //                 : null;

    //             // Flag reserved (O(1))
    //             $book->is_reserved_by_user = $reservedBookIds->has($book->id);

    //             return $book;
    //         });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    public function index(Request $request)
    {
        $userId = Auth::guard('sanctum')->id();

        $books = Book::query()
            ->where('books.status', 'active')
            ->select([
                'books.id',
                'books.title',
                'books.image_url',
                'books.author',
                'books.stock',
                'books.description',
                'books.loan_duration',
                'books.status',
                'books.category_id',
                'books.created_at',
                'books.updated_at',
            ])
            ->selectRaw(
                $userId
                    ? "EXISTS (
                    SELECT 1 FROM reservations
                    WHERE reservations.book_id = books.id
                    AND reservations.user_id = ?
                    AND reservations.status IN ('pending','available')
                  ) AS is_reserved_by_user"
                    : "false AS is_reserved_by_user",
                $userId ? [$userId] : []
            )
            ->with(['category:id,name,description,created_at,updated_at'])
            ->get();

        // 🚀 S3 URL diproses SEKALI
        $baseS3Url = config('filesystems.disks.s3.url');

        $books->each(function ($book) use ($baseS3Url) {
            $book->image_url = $book->image_url
                ? $baseS3Url . '/' . $book->image_url
                : null;
        });

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    // public function show($id)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $book = Book::with('category')->find($id);

    //     if (!$book) {
    //         return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan'], 404);
    //     }

    //     $book->image_url = asset('storage/' . $book->image_url);

    //     if ($user) {
    //         $book->is_borrowed_by_user = Loan::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->where('status', 'borrowed')
    //             ->exists();

    //         $book->has_active_reservation_by_user = Reservation::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->exists();
    //     } else {
    //         $book->is_borrowed_by_user = false;
    //         $book->has_active_reservation_by_user = false;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $book,
    //     ]);
    // }

    // public function show(Book $book)
    // {
    //     $user = Auth::user();

    //     // Ambil data dasar buku
    //     $bookData = $book->load('category');
    //     // $bookData->image_url = asset('storage/' . $bookData->image_url);
    //     // $bookData->image_url = Storage::disk('s3')->url($bookData->image_url);

    //     if ($bookData->image_url && Storage::disk('s3')->exists($bookData->image_url)) {
    //         $bookData->image_url = Storage::disk('s3')->url($bookData->image_url);
    //     } else {
    //         $bookData->image_url = null;
    //     }

    //     if ($user) {
    //         // Cek pinjaman aktif
    //         $bookData->is_borrowed_by_user = Loan::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->where('status', 'borrowed')
    //             ->exists();

    //         // Cari data reservasi aktif
    //         $activeReservation = Reservation::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->first();

    //         // Set flag dan data berdasarkan hasil pencarian reservasi
    //         $bookData->has_active_reservation_by_user = !is_null($activeReservation);
    //         $bookData->active_reservation_id = $activeReservation ? $activeReservation->id : null;
    //         $bookData->active_reservation_status = $activeReservation ? $activeReservation->status : null;
    //     } else {
    //         // Default value jika tidak ada user yang login
    //         $bookData->is_borrowed_by_user = false;
    //         $bookData->has_active_reservation_by_user = false;
    //         $bookData->active_reservation_id = null;
    //         $bookData->active_reservation_status = null;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $bookData,
    //     ]);
    // }

    public function show(Book $book)
    {
        $userId = Auth::id();

        $bookData = Book::query()
            ->where('books.id', $book->id)
            ->select([
                'books.id',
                'books.title',
                'books.image_url',
                'books.author',
                'books.stock',
                'books.description',
                'books.loan_duration',
                'books.status',
                'books.category_id',
                'books.created_at',
                'books.updated_at',
            ])
            ->selectRaw(
                $userId
                    ? "
        CASE
            WHEN EXISTS (
                SELECT 1 FROM loans
                WHERE loans.book_id = books.id
                AND loans.user_id = ?
                AND loans.status = 'borrowed'
            )
            THEN true
            ELSE false
        END AS is_borrowed_by_user
        "
                    : "false AS is_borrowed_by_user",
                $userId ? [$userId] : []
            )

            ->selectRaw(
                $userId
                    ? "
                (
                    SELECT id FROM reservations
                    WHERE reservations.book_id = books.id
                    AND reservations.user_id = ?
                    AND reservations.status IN ('pending','available')
                    LIMIT 1
                ) AS active_reservation_id
                "
                    : "null AS active_reservation_id",
                $userId ? [$userId] : []
            )
            ->selectRaw(
                $userId
                    ? "
                (
                    SELECT status FROM reservations
                    WHERE reservations.book_id = books.id
                    AND reservations.user_id = ?
                    AND reservations.status IN ('pending','available')
                    LIMIT 1
                ) AS active_reservation_status
                "
                    : "null AS active_reservation_status",
                $userId ? [$userId] : []
            )
            ->with(['category:id,name,description,created_at,updated_at'])
            ->firstOrFail();

        // Flag turunan (tanpa query)
        $bookData->has_active_reservation_by_user = !is_null($bookData->active_reservation_id);
        // $bookData->has_active_reservation_by_user =
        //     (bool) $bookData->active_reservation_id;
        $bookData->is_borrowed_by_user = (bool) $bookData->is_borrowed_by_user;


        // 🚀 S3 URL TANPA EXISTS CHECK
        $baseS3Url = config('filesystems.disks.s3.url');
        $bookData->image_url = $bookData->image_url
            ? $baseS3Url . '/' . $bookData->image_url
            : null;

        return response()->json([
            'success' => true,
            'data' => $bookData,
        ]);
    }
}
