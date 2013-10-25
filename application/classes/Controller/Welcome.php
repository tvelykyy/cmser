<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller 
{

    public function action_index()
    {
        $uri = $this->request->uri();
        $page = Model_Page::get_page_by_uri($uri);

        if ($page)
        {
            Resolver_Snippet::resolve($page->fields);
            $page->fields = Helper_Array::convert_array_to_associative_array_for_page($page->fields);

            echo Generator_Html::generate_html_by_filepath_and_params($page->filepath, $page->fields);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404();
        }
    }

} // End Welcome
