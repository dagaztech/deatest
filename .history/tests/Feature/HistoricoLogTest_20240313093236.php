<?php

namespace Tests\Unit\Models;

use App\Models\HistoricoLog;
use Tests\TestCase;

/**
 * Class HistoricoLogTest.
 *
 * @covers \App\Models\HistoricoLog
 */
final class HistoricoLogTest extends TestCase
{
    private HistoricoLog $historicoLog;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->historicoLog = new HistoricoLog();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->historicoLog);
    }

    public function testCrear(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
