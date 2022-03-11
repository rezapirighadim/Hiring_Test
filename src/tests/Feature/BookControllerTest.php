<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Mockery\Matcher\Closure;
use Tests\TestCase;

class BookControllerTest extends TestCase
{


    public function test_search_book_q_is_required()
    {
        $res = $this->get('api/search/book');
        $res->assertSessionHasErrors('q');
    }

    public function test_search_book_q_is_required_in_api()
    {
        $res = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('api/search/book');

        $res->assertStatus(422);
    }

    public function test_cash_should_return_empty_once()
    {
        Cache::shouldReceive('remember')
            ->with('test', '60', Closure::class)
            ->andReturn([]);

    }

    public function test_env_should_have_cache_ttl()
    {

        self::assertIsNumeric(env('CACHE_REMEMBER_MINUTE'));
    }

    public function test_env_should_have_scout_driver()
    {

        self::assertEquals( 'database' , env('SCOUT_DRIVER'));
    }

}
