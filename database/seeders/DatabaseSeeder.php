<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Cengizhan Durmuş',
            'email' => 'cengizhan@seopix.net',
            'password' => '123456789',
            'position' => 'Software Developer',
            'about' => 'I am a software developer.',
            'image' => 'images/SmkNytMyJVmPjdlKEUr8tvTSXoAoxIjJPz6Mhtup.jpg',
            'linkedin_url' => 'https://www.linkedin.com/in/cengizhan-durmuş/',
        ]);
    }
}
