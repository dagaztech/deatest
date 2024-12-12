<?php

namespace Tests\Unit\Models;

use App\Models\settings;
use Tests\TestCase;

/**
 * Class settingsTest.
 *
 * @covers \App\Models\settings
 */
final class settingsTest extends TestCase
{
    private settings $settings;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->settings = new settings();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->settings);
    }

    public function testSetEnvironmentValue(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
