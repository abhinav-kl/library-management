<?php

namespace Database\Seeders;

use App\Models\Books;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['book_name' => 'The Great Gatsby', 'published_year' => 1925, 'availability' => true, 'author_id' => 1, 'genre_id' => 1],
            ['book_name' => '1984', 'published_year' => 1949, 'availability' => true, 'author_id' => 2, 'genre_id' => 2],
            ['book_name' => 'The Hobbit', 'published_year' => 1937, 'availability' => true, 'author_id' => 3, 'genre_id' => 3],
            ['book_name' => 'To Kill a Mockingbird', 'published_year' => 1960, 'availability' => false, 'author_id' => 4, 'genre_id' => 4],
            ['book_name' => 'Tender is the Night', 'published_year' => 1934, 'availability' => true, 'author_id' => 1, 'genre_id' => 1],
            ['book_name' => 'Animal Farm', 'published_year' => 1945, 'availability' => true, 'author_id' => 2, 'genre_id' => 2],
            ['book_name' => 'The Lord of the Rings', 'published_year' => 1954, 'availability' => true, 'author_id' => 3, 'genre_id' => 3],
            ['book_name' => 'Go Set a Watchman', 'published_year' => 2015, 'availability' => false, 'author_id' => 4, 'genre_id' => 4],
            ['book_name' => 'This Side of Paradise', 'published_year' => 1920, 'availability' => true, 'author_id' => 1, 'genre_id' => 1],
            ['book_name' => 'Down and Out in Paris and London', 'published_year' => 1933, 'availability' => true, 'author_id' => 2, 'genre_id' => 2],
        ];

        foreach ($books as $book) {
            Books::create($book);
        }
    }
}
