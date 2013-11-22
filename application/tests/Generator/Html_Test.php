<?php defined('SYSPATH') or die('No direct access allowed!');

class Generator_Html_Test extends Unittest_TestCase
{
    public function test_generate_html_by_template_id_and_params()
    {
        /* Given. */
        $template_id = 1;
        $template = new stdClass();
        $template->path = 'path';

        $params = array('fake', 'fake', 'fake');

        $mocked_model_template = $this->getMock('Model_Template');
        $mocked_model_template->expects($this->once())
            ->method('get_template_by_id')
            ->with($template_id)
            ->will($this->returnValue($template));

        $mocked_generator_html = $this->getMock('Generator_Html', array('generate_html_by_path_and_params'),
            array($mocked_model_template));
        $mocked_generator_html->expects($this->once())
            ->method('generate_html_by_path_and_params')
            ->with('path', $params)
            ->will($this->returnValue('html'));

        /* When. */
        $actual_html = $mocked_generator_html->generate_html_by_template_id_and_params($template_id, $params);

        /* Then. */
        $this->assertEquals('html', $actual_html);
    }

}