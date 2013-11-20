<?php defined('SYSPATH') or die('No direct access allowed!');

class Controller_Dispatcher_Test extends Unittest_TestCase
{
    public function test_action_index_with_correct_output()
    {
        /* Given. */
        $request = new Request('news');
        $response = new Response();
        $dispatcher = new Controller_Dispatcher($request, $response);

        $dummy_page = $this->initDummyPage();

        $mocked_model_page = $this->getMock('Model_Page');
        $mocked_model_page->expects($this->once())
            ->method('get_page_by_uri')
            ->will($this->returnValue($dummy_page));
        $dispatcher->set_model_page($mocked_model_page);

        $mocked_snippet_resolver = $this->getMock('Snippet_Resolver');
        $mocked_snippet_resolver->expects($this->once())
            ->method('resolve_snippets')
            ->will($this->returnValue($dummy_page->fields));
        $dispatcher->set_snippet_resolver($mocked_snippet_resolver);

        $mocked_generator_html = $this->getMockBuilder('Generator_Html')
            ->disableOriginalConstructor()
            ->getMock();
        $mocked_generator_html->expects($this->once())
            ->method('generate_html_by_filepath_and_params')
            ->will($this->returnValue('html'));
        $dispatcher->set_generator_html($mocked_generator_html);

        /* Then. Weird order. Isn't it? :) */
        $this->expectOutputString('html');

        /* When. */
        $dispatcher->action_index();
    }

    public function test_action_index_404()
    {
        /* Given. */
        $request = new Request('news');
        $response = new Response();
        $dispatcher = new Controller_Dispatcher($request, $response);

        $mocked_model_page = $this->getMock('Model_Page');
        $mocked_model_page->expects($this->once())
            ->method('get_page_by_uri')
            ->will($this->returnValue(null));
        $dispatcher->set_model_page($mocked_model_page);

        /* When.*/
        try {
            $dispatcher->action_index();
        }
        catch (Kohana_HTTP_Exception_404 $e)
        {
            return;
        }

        /* Then. */
        $this->fail('An expected exception has not been raised.');
    }

    public function initDummyPage()
    {
        $page = new stdClass();
        $page->id = 1;
        $page->filepath = '/dummy/file/path';
        $page_field = new stdClass();
        $page_field->title = 'MAIN_TITLE';
        $page_field->page_field_content = 'Some super content';
        $page->fields = array($page_field);

        return $page;
    }
}