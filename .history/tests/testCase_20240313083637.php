<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

public class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }
}