<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

/**
 * Class UserTest.
 *
 * @covers \App\Models\User
 */
final class UserTest extends TestCase
{
    private User $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->user = new User();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->user);
    }

    public function testLoginSecurity(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testCurrentLanguage(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testSendPasswordResetNotification(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testUploadFolder(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testWithAccessToken(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testGetAvatarImageAttribute(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testHasVerifiedPhone(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

}
