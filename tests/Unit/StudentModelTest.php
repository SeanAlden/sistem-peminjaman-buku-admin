<?php

// namespace Tests\Unit;

// use Tests\TestCase;
// use App\Models\Loan;
// use App\Models\Student;
// use Illuminate\Foundation\Testing\RefreshDatabase;

// class StudentModelTest extends TestCase
// {
//     use RefreshDatabase;

//     /** @test */
//     public function student_has_many_loans()
//     {
//         $student = Student::factory()->create();

//         // Loan direlasikan lewat user_id, bukan student_id
//         $loan1 = Loan::factory()->create(['user_id' => $student->id]);
//         $loan2 = Loan::factory()->create(['user_id' => $student->id]);

//         $this->assertTrue($student->loans->contains($loan1));
//         $this->assertTrue($student->loans->contains($loan2));
//         $this->assertCount(2, $student->loans);
//     }
// }

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_has_many_loans()
    {
        $student = Student::factory()->create();

        // Buat user dan book agar foreign key valid
        $user = User::factory()->create(['id' => $student->id]);
        $book = Book::factory()->create();

        // Loan harus punya book_id & user_id yang valid
        $loan1 = Loan::factory()->create([
            'book_id' => $book->id,
            'user_id' => $student->id, 
        ]);

        $loan2 = Loan::factory()->create([
            'book_id' => $book->id,
            'user_id' => $student->id,
        ]);

        $this->assertTrue($student->loans->contains($loan1));
        $this->assertTrue($student->loans->contains($loan2));
        $this->assertCount(2, $student->loans);
    }
}

