<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $uno = User::factory()->create([
            'first_name' => 'usuario', 'last_name' => 'uno', 'email' => 'uno@gmail.com',
        ]);

        $dos = User::factory()->create([
            'first_name' => 'usuario', 'last_name' => 'dos', 'email' => 'dos@gmail.com',
        ]);

        Contact::factory(5)->for($uno)->create();
        Contact::factory(3)->for($dos)->create();
    }
}
