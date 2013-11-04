<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_Page_Test extends Model_Base_Test
{
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_Page('test');
    }

    public function test_get_pages_with_default_parameters()
    {
        $pages = $this->model->get_pages();
        $the_only_page = $pages[0];

        $this->assertNotEmpty($pages);
        $this->assertEquals(1, count($pages));
        $this->assertEquals(1, $the_only_page->id);
        $this->assertEquals('/', $the_only_page->uri);
        $this->assertEquals(0, $the_only_page->parent_id);
        $this->assertEquals(1, $the_only_page->template_id);
    }

    public function test_get_pages_get_page_with_offset_one()
    {
        $pages = $this->model->get_pages(1, 1);
        $the_only_page = $pages[0];

        $this->assertNotEmpty($pages);
        $this->assertEquals(1, count($pages));
        $this->assertEquals(2, $the_only_page->id);
        $this->assertEquals('/news', $the_only_page->uri);
        $this->assertEquals(1, $the_only_page->parent_id);
        $this->assertEquals(1, $the_only_page->template_id);
    }

    public function test_get_pages_with_limit_two()
    {
        $pages = $this->model->get_pages(0, 2);

        $this->assertNotEmpty($pages);
        $this->assertEquals(2, count($pages));
    }
}