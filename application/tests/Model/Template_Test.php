<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_Template_Test extends Model_Base_Test
{
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_Template('test');
        $this->runSchema('template-data.sql');
    }

    public function test_get_template_by_id_for_existent_template()
    {
        /* When. */
        $template = $this->model->get_template_by_id(1);

        /* Then. */
        $this->assertNotEmpty($template);
        $this->assertEquals(1, $template->id);
        $this->assertEquals('Main Template', $template->title);
        $this->assertEquals('index.html', $template->path);
    }

    public function test_get_template_by_id_for_non_existent_template()
    {
        /* When. */
        $template = $this->model->get_template_by_id(0);

        /* Then. */
        $this->assertFalse($template);
    }

}