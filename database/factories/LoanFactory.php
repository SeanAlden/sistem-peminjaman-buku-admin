<?php

// namespace Database\Factories;

// use App\Models\Loan;
// use App\Models\Book;
// use App\Models\User;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class LoanFactory extends Factory
// {
//     protected $model = Loan::class;

//     // public function definition(): array
//     // {
//     //     $loanDate = $this->faker->dateTimeBetween('-2 months', 'now');
//     //     $loanDuration = $this->faker->numberBetween(5, 14);
//     //     $returnDate = (clone $loanDate)->modify("+{$loanDuration} days");

//     //     return [
//     //         // Relasi: bisa reference factory Book & User, atau gunakan id manual saat create()
//     //         'book_id' => Book::factory(),
//     //         'user_id' => User::factory(),
//     //         'loan_date' => $loanDate,
//     //         'return_date' => $returnDate,
//     //         'actual_returned_at' => null,
//     //         'status' => 'borrowed', // atau sesuai enum/values di app kamu
//     //         'loan_duration' => $loanDuration,
//     //         'max_returned_at' => $returnDate,
//     //         'return_status_note' => null,
//     //         'late_days' => 0,
//     //         'fine_amount' => 0,
//     //     ];
//     // }

//     public function definition(): array
//     {
//         $loanDate = $this->faker->dateTimeBetween('-2 months', 'now');
//         $loanDuration = $this->faker->numberBetween(5, 14);
//         $maxReturnedAt = (clone $loanDate)->modify("+{$loanDuration} days");

//         return [
//             'book_id' => Book::factory(),
//             'user_id' => User::factory(),
//             'loan_date' => $loanDate,
//             'return_date' => $maxReturnedAt,
//             'actual_returned_at' => null,
//             'status' => 'borrowed',
//             'loan_duration' => $loanDuration,
//             'max_returned_at' => $maxReturnedAt,
//             'return_status_note' => null,
//             'late_days' => 0,
//             'fine_amount' => 0,
//         ];
//     }

//     public function returnedOnTime()
//     {
//         return $this->state(function (array $attributes) {
//             return [
//                 'status' => 'returned',
//                 'actual_returned_at' => $attributes['return_date'],
//                 'return_status_note' => 'Returned On Time',
//             ];
//         });
//     }

//     public function overdue()
//     {
//         return $this->state(function (array $attributes) {
//             return [
//                 'status' => 'returned',
//                 'actual_returned_at' => now()->addDays(10),
//                 'return_status_note' => 'Overdue',
//                 'late_days' => 10,
//                 'fine_amount' => 10000,
//             ];
//         });
//     }
// }

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition(): array
    {
        $loanDate = $this->faker->dateTimeBetween('-2 months', 'now');
        $loanDuration = $this->faker->numberBetween(5, 14);
        $maxReturnedAt = (clone $loanDate)->modify("+{$loanDuration} days");

        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'loan_date' => $loanDate,
            'return_date' => $maxReturnedAt,
            'actual_returned_at' => null,
            'status' => 'borrowed',
            'loan_duration' => $loanDuration,
            'max_returned_at' => $maxReturnedAt,
            'return_status_note' => null,
            'late_days' => 0,
            'fine_amount' => 0,
        ];
    }

    public function returnedOnTime()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'returned',
            'actual_returned_at' => $attributes['return_date'],
            'return_status_note' => 'Returned On Time',
        ]);
    }

    public function returnedEarlier()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'returned',
            'actual_returned_at' => now()->subDays(1),
            'return_status_note' => 'Returned Earlier',
        ]);
    }

    public function lateWithinAllowed(int $daysLate = 2)
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'returned',
            'actual_returned_at' => now()->addDays($daysLate),
            'return_status_note' => 'Late Within Allowed Duration',
            'late_days' => $daysLate,
        ]);
    }

    public function overdue(int $daysLate = 5)
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'returned',
            'actual_returned_at' => now()->addDays($daysLate),
            'return_status_note' => 'Overdue',
            'late_days' => $daysLate,
            'fine_amount' => $daysLate * 1000,
        ]);
    }
}