<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompleteProfileRequest extends FormRequest
{
   
    private static $userTypes = ['artist', 'buyer', 'curator', 'enthusiast'];
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => ['required', 'string','max:255'],
          'type' => ['required', 'string',  'max:255', Rule::in(static::$userTypes)],
          'address' => ['required', 'string',  'max:255'],
          'country' => ['required', 'string',  'max:255'],
          'notify_on_updates' => ['required', 'boolean'],
          'notify_on_events_and_virtual_exhibitions' => ['required', 'boolean'],
        ];
    }
}
