<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function search()
    {
        $q = request("q");
        if (!$q) return [];

        // cache in redis by laravel .
         return  Cache::remember("book.${q}",3600 ,function () use(&$q) {

             // this part developed by using scout that available for mysql in laravel 9 and configured for search in full text mod.
            $result_from_books =  Book::search($q)
                 ->query(fn ($query) => $query->with('authors'))
                 ->get()->toArray();

             // in this part in order to search in authors table as same as books table I tried to get book from many to many relation
             // that we have, and after that get books by id which we get them  from first query.
             $authors_books_id = DB::table("authors")->select(['author_book.book_id'])
                ->rightJoin('author_book' , 'authors.id' , '=' , 'author_book.author_id')
                ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)" ,$q)->get()->pluck('book_id')->toArray();

             $results_by_author_name = Book::whereIn('id',$authors_books_id)->with('authors')->get()->toArray();

            return array_unique(array_merge($results_by_author_name , $result_from_books) , SORT_REGULAR);

         });
    }
}
