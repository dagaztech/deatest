<?php

namespace Tests\Unit\Models;

use App\Models\Announcement;
use Tests\TestCase;

/**
 * Class AnnouncementTest.
 *
 * @covers \App\Models\Announcement
 */
final class AnnouncementTest extends TestCase
{
    private Announcement $announcement;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->announcement = new Announcement();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->announcement);
    }

    public function testGetSlugOptions(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
