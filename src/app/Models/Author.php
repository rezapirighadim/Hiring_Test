<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\ErrorHandler\reRegister;

class Author extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function books(){
        return $this->belongsToMany(Book::class);
    }

    public function getBookIds()
    {
        return $this->books()->getRelatedIds();
    }

    /**
     * in this part in order to search in authors table as same as books table I tried to get book from many to many relation
     * that we have, and after that get books by id which we get them  from first query.
     * @param $q
     * @return mixed
     */
    public function search_authors_books($q)
    {
        $authors_books_id = DB::table("authors")->select(['author_book.book_id'])
            ->rightJoin('author_book' , 'authors.id' , '=' , 'author_book.author_id')
            ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)" ,$q)->pluck('book_id')->toArray();

        return Book::whereIn('id',$authors_books_id)->with('authors')->get()->toArray();
    }

}
