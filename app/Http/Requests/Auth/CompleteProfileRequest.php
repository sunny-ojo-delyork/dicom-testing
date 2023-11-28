<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompleteProfileRequest extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => ['required', 'string','max:255'],
          'type' => ['required', 'string',  'max:255', Rule::in(User::$userTypes)],
          'address' => ['nullable', 'string',  'max:255'],
          'country' => ['nullable', 'string',  'max:255'],
          'notify_on_updates' => ['nullable', 'boolean'],
          'notify_on_events_and_virtual_exhibitions' => ['nullable', 'boolean'],
        ];
    }
}
