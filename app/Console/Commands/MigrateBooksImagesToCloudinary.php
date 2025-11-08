<?php

// namespace App\Console\Commands;

// use App\Models\Book;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// class MigrateBooksImagesToCloudinary extends Command
// {
//     protected $signature = 'migrate:cloudinary-books';
//     protected $description = 'Upload gambar lama buku ke Cloudinary dan update kolom image';

//     public function handle()
//     {
//         $this->info("=== MIGRASI GAMBAR KE CLOUDINARY DIMULAI ===");

//         $books = Book::all();
//         $migrated = 0;
//         $skipped = 0;
//         $missing = 0;

//         foreach ($books as $book) {

//             // 1. Jika NULL atau kosong → skip
//             if (empty($book->image_url)) {
//                 $skipped++;
//                 $this->warn("SKIP  : ID {$book->id} → Kolom image NULL / kosong");
//                 continue;
//             }

//             // 2. Jika sudah berupa URL → skip
//             if (str_starts_with($book->image_url, "http")) {
//                 $skipped++;
//                 $this->line("SKIP  : ID {$book->id} → Sudah Cloudinary URL");
//                 continue;
//             }

//             // 3. Pastikan path benar
//             $relativePath = $book->image_url; // contoh: book_images/xxx.jpg
//             $fullLocalPath = "public/storage/" . $relativePath;  
            
//             // 4. Cek file ada atau tidak
//             if (!Storage::exists($fullLocalPath)) {
//                 $missing++;
//                 $this->error("MISS  : ID {$book->id} → File tidak ditemukan: {$fullLocalPath}");
//                 continue;
//             }

//             $this->info("UPLOAD: ID {$book->id} → Mengupload {$relativePath}");

//             // 5. Upload ke Cloudinary
//             $uploaded = Cloudinary::upload(Storage::path($fullLocalPath), [
//                 "folder" => "book_images"
//             ]);

//             $cloudUrl = $uploaded->getSecurePath();

//             // 6. Update database
//             $book->update([
//                 "image_url" => $cloudUrl
//             ]);

//             $migrated++;
//         }

//         // SUMMARY
//         $this->info("\n=== MIGRASI SELESAI ===");
//         $this->info("Migrated : {$migrated}");
//         $this->info("Skipped  : {$skipped}");
//         $this->info("Missing  : {$missing}");

//         return Command::SUCCESS;
//     }
// }

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MigrateBooksImagesToCloudinary extends Command
{
    protected $signature = 'migrate:cloudinary-books';
    protected $description = 'Upload gambar lama buku ke Cloudinary dan update kolom image_url';

    public function handle()
    {
        $this->info("=== MIGRASI GAMBAR KE CLOUDINARY DIMULAI ===");

        $books = Book::all();
        $migrated = 0;
        $skipped = 0;
        $missing = 0;

        foreach ($books as $book) {

            // 1) Ambil nilai kolom
            $img = $book->image_url;

            // 2) Skip kalau NULL atau kosong
            if (empty($img) || trim($img) === '') {
                $skipped++;
                $this->warn("SKIP  : ID {$book->id} → Kolom image_url NULL / kosong");
                continue;
            }

            // 3) Jika sudah berupa URL (sudah Cloudinary atau link lain) -> skip
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $skipped++;
                $this->line("SKIP  : ID {$book->id} → Sudah berupa URL");
                continue;
            }

            // 4) Normalisasi path:
            // Bisa jadi nilai di DB: "book_images/xxx.jpg"  OR "storage/book_images/xxx.jpg" OR "public/book_images/xxx.jpg"
            // Kita ubah menjadi relatif terhadap disk 'public': "book_images/xxx.jpg"
            $relativePath = $img;

            // jika ada prefix "storage/" atau "public/" hapus
            $relativePath = preg_replace('#^storage/#', '', $relativePath);
            $relativePath = preg_replace('#^public/#', '', $relativePath);

            // 5) Cek file pada disk 'public'
            if (!Storage::disk('public')->exists($relativePath)) {
                $missing++;
                $this->error("MISS  : ID {$book->id} → File tidak ditemukan di disk 'public': {$relativePath}");
                continue;
            }

            // 6) Dapatkan absolute path file untuk upload
            $absolutePath = Storage::disk('public')->path($relativePath);

            $this->info("UPLOAD: ID {$book->id} → Mengupload '{$relativePath}' (abs: {$absolutePath})");

            try {
                // 7) Upload ke Cloudinary, taruh di folder book_images
                $uploaded = Cloudinary::upload($absolutePath, [
                    'folder' => 'book_images'
                ]);

                $cloudUrl = $uploaded->getSecurePath();

                // 8) Update DB
                $book->update([
                    'image_url' => $cloudUrl
                ]);

                $migrated++;
            } catch (\Throwable $e) {
                $this->error("ERR   : ID {$book->id} → Upload gagal: " . $e->getMessage());
                // jangan langsung exit; lanjutkan ke yang lain
                continue;
            }
        }

        // SUMMARY
        $this->info("\n=== MIGRASI SELESAI ===");
        $this->info("Migrated : {$migrated}");
        $this->info("Skipped  : {$skipped}");
        $this->info("Missing  : {$missing}");

        return Command::SUCCESS;
    }
}

