<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
class StudentRegisterRequestTest extends TestCase
{
     public function test_passes_with_valid_data()
    {
        $data = [
            'name' => 'Alice Example',
            'email' => 'alice@example.com',
        ];

        $validator = Validator::make($data, (new StudentRequest())->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_fails_when_name_is_missing()
    {
        $data = [
            'email' => 'alice@example.com',
        ];

        $validator = Validator::make($data, (new StudentRequest())->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_fails_when_email_is_missing()
    {
        $data = [
            'name' => 'Alice',
        ];

        $validator = Validator::make($data, (new StudentRequest())->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    public function test_fails_when_email_is_invalid()
    {
        $data = [
            'name' => 'Alice',
            'email' => 'not-an-email',
        ];

        $validator = Validator::make($data, (new StudentRequest())->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    public function test_fails_when_email_is_not_unique()
    {
        Student::factory()->create(['email' => 'taken@example.com']);

        $data = [
            'name' => 'New User',
            'email' => 'taken@example.com',
        ];

        $validator = Validator::make($data, (new StudentRequest())->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }
}
