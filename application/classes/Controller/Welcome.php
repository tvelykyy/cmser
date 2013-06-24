<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller 
{
    function __construct(\Request $request, \Response $response) 
    {
        parent::__construct($request, $response);
    }
    
    public function action_index()
    {
        $uri = $this->request->uri();
        $page_model = new Model_Page();
        $page = $page_model->get_page_by_uri($uri);
        
        if ($page)
        {
            Resolver_Snippet::resolve($page->fields);
            echo Renderer::generate_html($page);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404();
        }
    }    
   
} // End Welcome
