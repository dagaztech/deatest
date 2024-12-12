<?php

namespace Tests\Unit\Models;

use App\Models\DocumentGenrator;
use Tests\TestCase;

/**
 * Class DocumentGenratorTest.
 *
 * @covers \App\Models\DocumentGenrator
 */
final class DocumentGenratorTest extends TestCase
{
    private DocumentGenrator $documentGenrator;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->documentGenrator = new DocumentGenrator();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->documentGenrator);
    }

    public function testDocument(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testGetFormArray(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testDocument_menu(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testGetSlugOptions(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
