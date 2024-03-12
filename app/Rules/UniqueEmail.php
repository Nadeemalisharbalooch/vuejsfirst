<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UniqueEmail implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email already exists in the 'users' table
        return !User::where('email', $value)->exists();
    }

    public function message()
    {
        return 'This email is already registered.';
    }
}
