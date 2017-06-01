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
        $this->assertTrue(Schema::hasTable('maki_sections'));
        $this->assertTrue(Schema::hasTable('maki_field_values'));
        $this->assertTrue(Schema::hasTable('maki_links'));
        $this->assertTrue(Schema::hasTable('maki_pages'));
        $this->assertTrue(Schema::hasTable('maki_page_section'));
        $this->assertTrue(Schema::hasTable('maki_field_subsets'));
    }
}
