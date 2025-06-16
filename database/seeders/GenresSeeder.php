<?php

namespace Database\Seeders;

use App\Models\Genres;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genres::create(['name' => 'Classic']);
        Genres::create(['name' => 'Dystopian']);
        Genres::create(['name' => 'Fantasy']);
        Genres::create(['name' => 'Historical Fiction']);
    }
}
