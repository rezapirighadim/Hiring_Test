<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BookUnitTest extends TestCase
{

    public function test_env_should_exists()
    {
        self::assertFileExists('.env');
    }
}
