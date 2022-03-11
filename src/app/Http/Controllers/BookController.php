<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * manage search api based on book title , book publisher , book summery and author name
     * @param SearchBookRequest $request
     * @param Book $book
     * @param Author $author
     * @return mixed
     */
    public function search(SearchBookRequest $request , Book $book , Author $author)
    {
        $q = $request["q"];
         return  Cache::remember("book.${q}", (int) env('CACHE_REMEMBER_MINUTE' , 60) * 60 ,function () use(&$q , &$book , &$author) {
            $result_from_books = $book->search_book($q);
            $results_by_author_name = $author->search_authors_books($q);
            return $this->search_response( array_unique(array_merge($results_by_author_name , $result_from_books) , SORT_REGULAR) ) ;
         });
    }

    /**
     * responsible to produce data for search api
     * @param array $response
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function search_response(array $response)
    {
        if (!$response) return response([__('api.response.not_found')] , Response::HTTP_NOT_FOUND);
        return response($response , Response::HTTP_OK);
    }
}
