<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'lname' => [ 'string', 'max:255'],
             'middlename' => [ 'string', 'max:255'],
              'fname' => [ 'string', 'max:255'],
              'mobile_number' => ['nullable', 'numeric', 'digits:11'],
                'address' => [ 'string', 'max:255'],
                 'gender' => ['string', 'max:255'],
                 'bdate' => ['date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
