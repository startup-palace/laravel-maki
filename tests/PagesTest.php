<?php

namespace StartupPalace\Maki\Tests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use StartupPalace\Maki\Page;

class PagesTest extends TestCase
{
    use DatabaseMigrations;

    public function testPageSectionRelation()
    {
        $page = Page::create([
            'published_at' => Carbon::now(),
            'title' => 'My first page',
            'slug' => 'my-first-page',
        ]);

        $this->assertEquals(0, $page->sections()->count());

        $section = $this->createSectionAndFieldValues();

        $page->sections()->save($section);

        $this->assertEquals(1, $page->sections()->count());
    }

    public function testRouteNotFound()
    {
        $response = $this->call('GET', route('page.show', ['my-first-page']));

        $response->assertStatus(404);
    }

    public function testPageRendering()
    {
        $page = Page::create([
            'published_at' => Carbon::now(),
            'title' => 'My first page',
            'slug' => 'my-first-page',
        ]);

        $firstSection = $this->createSectionAndFieldValues();

        $secondSection = $this->createSectionAndFieldValues();
        $secondSectionTitle = $secondSection->fields['title'];
        $secondSectionTitle->data = 'Second section';
        $secondSectionTitle->save();

        $page->sections()->saveMany([$firstSection, $secondSection]);

        $response = $this->get(route('page.show', ['my-first-page']));
        $response->assertStatus(200);

        $response->assertSee('<h1>My first page</h1>');

        $response->assertSee('<h2>A simple title</h2>');
        $response->assertSee('<h2>Second section</h2>');
    }
}
