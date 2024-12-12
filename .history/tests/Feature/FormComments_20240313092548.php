<?php

namespace Tests\Unit\Models;

use App\Models\FormComments;
use Tests\TestCase;

/**
 * Class FormCommentsTest.
 *
 * @covers \App\Models\FormComments
 */
final class FormCommentsTest extends TestCase
{
    private FormComments $formComments;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->formComments = new FormComments();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->formComments);
    }

    public function testReplyby(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
