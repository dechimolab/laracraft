<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()?->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId . ',user_id'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'git_signature' => ['nullable', 'string', 'max:255'],
            'pint_format' => ['nullable', 'boolean'],
            'pest_test' => ['nullable', 'boolean'],
            'docker_compose' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom attribute names for validation errors in Thai.
     */
    public function attributes(): array
    {
        return [
            'name' => 'ชื่อ-นามสกุล',
            'email' => 'อีเมลสำหรับงาน',
            'timezone' => 'ไทม์โซน',
            'git_signature' => 'Git Committer Signature',
        ];
    }
}
