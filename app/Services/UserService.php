<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserService {

    public function userCreate(): void
    {
        $user = [
            'name'=> 'Proverka',
            'email'=> 'proverka@proverka.ru',
            'email_verified_at' => now(),
            'password'=> Hash::make('proverka'),
            'balance'=> 777,
            'remember_token' => Str::random(10),
        ];
        if (User::where('name', 'Proverka')->first() === null) {
            User::class::create($user);
        }
    }

}
