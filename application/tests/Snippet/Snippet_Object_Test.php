<?php defined('SYSPATH') or die('No direct access allowed!');

class Snippet_Object_Test extends Unittest_TestCase
{

    function test_from_string()
    {
        /* Given. */
        $snippet_str = 'Model_Page.get_all_pages_uri.1?above=0&less=3';

        /* When. */
        $snippet = new Snippet_Object($snippet_str);

        /* Then. */
        $this->assertNotNull($snippet);
        $this->assertEquals(get_class(new Model_Page()), get_class($snippet->get_model()));
        $this->assertEquals('get_all_pages_uri', $snippet->get_method());
        $this->assertEquals(1, $snippet->get_template_id());
        $this->assertEquals(array('above' => 0, 'less' => 3), $snippet->get_params());
    }

    function test_from_string_with_client_params()
    {
        /* Given. */
        $snippet_str = 'Model_Page.get_all_pages_uri.1?above={above}&less={less}';

        /* When. */
        $snippet = new Snippet_Object($snippet_str, array('above' =>  10, 'less' => 15));

        /* Then. */
        $this->assertNotNull($snippet);
        $this->assertEquals(get_class(new Model_Page()), get_class($snippet->get_model()));
        $this->assertEquals('get_all_pages_uri', $snippet->get_method());
        $this->assertEquals(1, $snippet->get_template_id());
        $this->assertEquals(array('above' => 10, 'less' => 15), $snippet->get_params());
    }

    function test_generate_html()
    {
        /* Given. */
        $mocked_model_page = $this->getMock('Model_Page');
        $mocked_model_page->expects($this->once())
            ->method('get_all_pages_uri')
            ->will($this->returnValue(array(1)));

        $mocked_generator_html = $this->getMock('Generator_Html');
        $mocked_generator_html->expects($this->once())
            ->method('generate_html_by_template_id_and_params')
            ->with(1, array('params' => array(1)))
            ->will($this->returnValue('super_html'));

        $snippet_str = 'Model_Page.get_all_pages_uri.1?above=0&less=3';

        /* Passing model as null to test setter. */
        $snippet = new Snippet_Object($snippet_str);
        $snippet->set_generator_html($mocked_generator_html);
        $snippet->set_model($mocked_model_page);

        /* When. */
        $html = $snippet->generate_html();

        /* Then. */
        $this->assertEquals('super_html', $html);

    }

}