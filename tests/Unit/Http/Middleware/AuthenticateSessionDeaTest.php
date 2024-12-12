<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\AuthenticateSessionDea;
use Tests\TestCase;

/**
 * Class AuthenticateSessionDeaTest.
 *
 * @covers \App\Http\Middleware\AuthenticateSessionDea
 */
final class AuthenticateSessionDeaTest extends TestCase
{
    private AuthenticateSessionDea $authenticateSessionDea;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->authenticateSessionDea = new AuthenticateSessionDea();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->authenticateSessionDea);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
