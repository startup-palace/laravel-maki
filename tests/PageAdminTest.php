<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Routing\Router;
use StartupPalace\Maki\Page;

class PageAdminTest extends TestCase
{
    use DatabaseMigrations;

    public function testRoutesExist()
    {
        $router = app('router');

        $this->assertTrue($router->has('admin.page.index'));
        $this->assertTrue($router->has('admin.page.show'));
        $this->assertTrue($router->has('admin.page.store'));
        $this->assertTrue($router->has('admin.page.update'));
        $this->assertTrue($router->has('admin.page.destroy'));
    }

    public function testStorePage()
    {
        $this->postJson(route('admin.page.store'), [])
            ->assertStatus(422);

        $response = $this->postJson(route('admin.page.store'), [
            'title' => 'My test page',
            'slug' => 'my-test-page',
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'title' => 'My test page',
                'slug' => 'my-test-page',
            ]);

        $this->assertEquals(1, Page::count());
    }

    public function testGetPage()
    {
        $page = $this->createPage();

        $this->get(route('admin.page.show', [$page->slug]))
            ->assertSuccessful()
            ->assertJson([
                'title' => 'My test page',
                'slug' => 'my-test-page',
            ]);
    }

    public function testGetPages()
    {
        $page = $this->createPage();

        $this->get(route('admin.page.index'))
            ->assertSuccessful()
            ->assertJsonFragment([
                'title' => 'My test page',
                'slug' => 'my-test-page',
            ]);
    }

    public function testUpdatePage()
    {
        $page = $this->createPage();

        $this->putJson(route('admin.page.update', [$page->slug]), [])
            ->assertStatus(422);

        $response = $this->putJson(route('admin.page.update', [$page->slug]), [
            'title' => 'My new title',
            'slug' => 'my-new-title',
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'title' => 'My new title',
                'slug' => 'my-new-title',
            ]);
    }

    public function testDeletePage()
    {
        $page = $this->createPage();

        $this->delete(route('admin.page.destroy', [$page->slug]))
            ->assertSuccessful();

        $this->get(route('admin.page.show', [$page->slug]))
            ->assertStatus(404);
    }

    protected function createPage()
    {
        return Page::create([
            'title' => 'My test page',
            'slug' => 'my-test-page',
        ]);
    }
}
