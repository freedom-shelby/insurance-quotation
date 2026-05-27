<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@test.com'],
            [
                'name'     => 'Test User',
                'password' => 'test',
            ],
        );

        $this->command->info('Test user ready → email: test@test.com  password: test');
    }
}
