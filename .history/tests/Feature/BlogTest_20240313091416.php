<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use Tests\TestCase;

/**
 * Class BlogTest.
 *
 * @covers \App\Models\Blog
 */
final class BlogTest extends TestCase
{
    private Blog $blog;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->blog = new Blog();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->blog);
    }

    public function testGetSlugOptions(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
