<?php

namespace Database\Seeders;

use App\Models\Authors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Authors::create(['name' => 'F. Scott Fitzgerald']);
        Authors::create(['name' => 'George Orwell']);
        Authors::create(['name' => 'J.R.R. Tolkien']);
        Authors::create(['name' => 'Harper Lee']);
    }
}
