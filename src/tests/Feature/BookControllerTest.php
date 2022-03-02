<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Mockery\Matcher\Closure;
use Tests\TestCase;

class BookControllerTest extends TestCase
{

    public function test_search_route_exists()
    {
        $res = $this->get('search/book');
        $res->assertStatus(200);
    }

    public function test_search_return_empty_array_without_q()
    {
        $res = $this->get('search/book');
        $res->assertExactJson([]);
    }

    public function test_cash_should_return_empty_once()
    {
        Cache::shouldReceive('remember')
            ->with('test', '60', Closure::class)
            ->andReturn([]);
    }


    // assertJsonExact TODO ...

}
