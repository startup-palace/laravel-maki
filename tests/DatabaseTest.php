<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Support\Facades\Schema;

class DatabaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench']);
    }

    public function testRunningMigration()
    {
        $this->assertTrue(Schema::hasTable('sections'));
        $this->assertTrue(Schema::hasTable('field_values'));
    }
}
