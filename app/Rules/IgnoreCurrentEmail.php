<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class IgnoreCurrentEmail implements ValidationRule
{

    protected $userId;

    // Constructor para pasar el ID del usuario que está actualizando
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existe_mail = DB::table('users')
        ->where('email', $value)
        ->where('id', '!=', $this->userId) // Excluir el usuario actual
        ->exists();

        if ($existe_mail) {
            $fail('The :attribute has been taken.');
        }
    }
}
