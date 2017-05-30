<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;

class DatabaseTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tests migrations are correctly executed
     */
    public function testRunningMigration()
    {
        $this->assertTrue(Schema::hasTable('sections'));
        $this->assertTrue(Schema::hasTable('field_values'));
        $this->assertTrue(Schema::hasTable('links'));
        $this->assertTrue(Schema::hasTable('pages'));
        $this->assertTrue(Schema::hasTable('page_section'));
    }
}
