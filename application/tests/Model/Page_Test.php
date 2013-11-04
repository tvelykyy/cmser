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
        /* When. */
        $pages = $this->model->get_pages();
        $the_only_page = $pages[0];

        /* Then. */
        $this->assertNotEmpty($pages);
        $this->assertEquals(1, count($pages));
        $this->assertEquals(1, $the_only_page->id);
        $this->assertEquals('/', $the_only_page->uri);
        $this->assertEquals(0, $the_only_page->parent_id);
        $this->assertEquals(1, $the_only_page->template_id);
    }

    public function test_get_pages_get_page_with_offset_one()
    {
        /* When. */
        $pages = $this->model->get_pages(1, 1);
        $the_only_page = $pages[0];

        /* Then. */
        $this->assertNotEmpty($pages);
        $this->assertEquals(1, count($pages));
        $this->assertEquals(2, $the_only_page->id);
        $this->assertEquals('/news', $the_only_page->uri);
        $this->assertEquals(1, $the_only_page->parent_id);
        $this->assertEquals(1, $the_only_page->template_id);
    }

    public function test_get_pages_with_limit_two()
    {
        /* When. */
        $pages = $this->model->get_pages(0, 2);

        /* Then. */
        $this->assertNotEmpty($pages);
        $this->assertEquals(2, count($pages));
    }

    public function test_get_page_by_uri_get_page_with_full_info()
    {
        /* When. */
        $page = $this->model->get_page_by_uri('/news');

        /* Then. */
        $this->assertNotNull($page);
        $this->assertEquals(2, $page->id);
        $this->assertEquals('index.html', $page->filepath);
        $this->assertEquals(3, count($page->fields));
        $this->assertEquals('MAIN_CONTENT', $page->fields[0]->title);
        $this->assertEquals('This is news page.', $page->fields[0]->page_field_content);
        $this->assertEquals('HEADER', $page->fields[1]->title);
        $this->assertEquals('This is news page title.', $page->fields[1]->page_field_content);
        $this->assertEquals('FOOTER', $page->fields[2]->title);
        $this->assertEquals('This is news page footer.', $page->fields[2]->page_field_content);
    }

    public function test_get_page_by_uri_with_no_existent_page()
    {
        /* When. */
        $page = $this->model->get_page_by_uri('/non-existent-page');

        /* Then. */
        $this->assertFalse($page);
    }
}