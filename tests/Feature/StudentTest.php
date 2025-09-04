<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin & login
        $this->admin = User::factory()->create([
            'usertype' => 'admin', // pastikan field ini ada di tabel users
        ]);

        $this->actingAs($this->admin);
    }

    /** @test */
    public function it_can_display_students_index_page()
    {
        Student::factory()->count(3)->create();

        $response = $this->get(route('students.index'));

        $response->assertStatus(200);
        $response->assertViewIs('student');
        $response->assertViewHas('students');
    }

    /** @test */
    public function it_can_create_a_student()
    {
        $studentData = [
            'name' => 'John Doe',
            'major' => 'Computer Science',
            'email' => 'johndoe@example.com',
            'phone' => '081234567890',
            'description' => 'Mahasiswa tingkat akhir',
        ];

        $response = $this->post(route('students.store'), $studentData);

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', ['email' => 'johndoe@example.com']);
    }

    /** @test */
    public function it_fails_to_create_student_with_invalid_email()
    {
        $studentData = [
            'name' => 'Jane Doe',
            'major' => 'Informatics',
            'email' => 'invalid-email', // ❌ salah format
            'phone' => '081234567890',
        ];

        $response = $this->post(route('students.store'), $studentData);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('students', ['name' => 'Jane Doe']);
    }

    /** @test */
    public function it_fails_to_create_student_with_invalid_phone()
    {
        $studentData = [
            'name' => 'Mark Smith',
            'major' => 'Information Systems',
            'email' => 'mark@example.com',
            'phone' => '12345', // ❌ kurang dari 12 digit
        ];

        $response = $this->post(route('students.store'), $studentData);

        $response->assertSessionHasErrors(['phone']);
        $this->assertDatabaseMissing('students', ['email' => 'mark@example.com']);
    }

    /** @test */
    public function it_can_show_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->get(route('students.show', $student->id));

        $response->assertStatus(200);
        $response->assertViewIs('student_show');
        $response->assertViewHas('student', $student);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        $student = Student::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'major' => 'Information Systems',
            'email' => 'updated@example.com',
            'phone' => '081234567899',
            'description' => 'Update description',
        ];

        $response = $this->put(route('students.update', $student->id), $updateData);

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', ['email' => 'updated@example.com']);
    }

    /** @test */
    public function it_fails_to_update_student_with_invalid_data()
    {
        $student = Student::factory()->create();

        $invalidData = [
            'name' => '',
            'major' => 'Informatics',
            'email' => 'wrong-format',
            'phone' => '123',
        ];

        $response = $this->put(route('students.update', $student->id), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'phone']);
        $this->assertDatabaseHas('students', ['id' => $student->id]); // masih ada, tidak hilang
    }

    /** @test */
    public function it_can_delete_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->delete(route('students.destroy', $student->id));

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
