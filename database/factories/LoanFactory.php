<?php

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
        $returnDate = (clone $loanDate)->modify("+{$loanDuration} days");

        return [
            // Relasi: bisa reference factory Book & User, atau gunakan id manual saat create()
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'loan_date' => $loanDate,
            'return_date' => $returnDate,
            'actual_returned_at' => null,
            'status' => 'borrowed', // atau sesuai enum/values di app kamu
            'loan_duration' => $loanDuration,
            'max_returned_at' => $returnDate,
            'return_status_note' => null,
            'late_days' => 0,
            'fine_amount' => 0,
        ];
    }
}
