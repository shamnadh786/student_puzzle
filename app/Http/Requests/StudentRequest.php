<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function rules(): array
    {
         return [
            'name'  => 'required|string|min:2',
            'email' => 'required|email|unique:students,email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
