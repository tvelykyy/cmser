<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller 
{

    public function action_index()
    {
        $uri = $this->request->uri();
        $page_model = new Model_Page();
        $page = $page_model->get_page_by_uri($uri);

        if ($page)
        {
            Resolver_Snippet::resolve($page->fields);
            echo Renderer::convert_fields_and_generate_html($page);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404();
        }
    }    
   
} // End Welcome
