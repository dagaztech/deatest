<?php

namespace Tests\Unit\Models;

use App\Models\DashboardWidget;
use Tests\TestCase;

/**
 * Class DashboardWidgetTest.
 *
 * @covers \App\Models\DashboardWidget
 */
final class DashboardWidgetTest extends TestCase
{
    private DashboardWidget $dashboardWidget;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->dashboardWidget = new DashboardWidget();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dashboardWidget);
    }

    public function testForm(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testPoll(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testCreatorId(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
