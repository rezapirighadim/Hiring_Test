<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $booksCount = 1000;
        Book::factory($booksCount)->create();
        Author::factory($booksCount *= 1.4)->create();

        Book::all()->each(function ($book) use ($booksCount) {
            $book->authors()->attach(
               Author::all()->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
