<?php

namespace App\Http\Requests;

use App\Models\QuoteRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Non-string input (e.g. name[]=x) is left as-is so validation rejects it instead of a 500.
        $str = fn (string $key) => is_string($this->input($key)) ? trim($this->input($key)) : $this->input($key);
        $phone = $str('phone');

        $this->merge([
            'phone' => is_string($phone) ? preg_replace('/[\s\-()]/', '', $phone) : $phone,
            'name' => $str('name'),
            'email' => $this->filled('email') ? $str('email') : null,
            'service_id' => $this->filled('service_id') ? $this->input('service_id') : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            // Bangladeshi mobile (01XXXXXXXXX, +8801…) or an international number in E.164 form.
            'phone' => ['required', 'string', 'regex:/^((\+?88)?01[3-9]\d{8}|\+[1-9]\d{7,14})$/'],
            'email' => ['nullable', 'email:rfc', 'max:150'],
            'business_name' => ['nullable', 'string', 'max:150'],
            'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->whereNull('deleted_at')],
            'budget' => ['nullable', Rule::in(QuoteRequest::PUBLIC_BUDGETS)],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter your number with country code, e.g. +1 555 123 4567.',
        ];
    }

    /** Normalise Bangladeshi numbers to +8801XXXXXXXXX. */
    public function normalizedPhone(): string
    {
        $phone = (string) $this->validated('phone');

        if (preg_match('/^(\+?88)?(01[3-9]\d{8})$/', $phone, $m)) {
            return '+88'.$m[2];
        }

        return $phone;
    }
}
