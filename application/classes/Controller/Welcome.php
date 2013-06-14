<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {
   
    function __construct(\Request $request, \Response $response) 
    {
        parent::__construct($request, $response);
    }
    
    public function action_index()
    {
        $uri = $this->request->uri();
        $page_model = new Model_Page();
        $page = $page_model->get_page_by_uri($uri);

        $this->resolve_snippets($page->fields);
        echo Renderer::generate_html($page);         
    }
    
    private function resolve_snippets($fields)
    {
        foreach($fields as $field)
        {            
            preg_match_all('/\\[\\[(.*?)\\]\\]/', $field->page_field_content, $snippets);
            /* $snippets[0] returns match like this [[(.*?)]], we need (.*?). */
            foreach($snippets[1] as $snippet_str)
            {
                $snippet = new Snippet($snippet_str);
                $template_model = new Model_Template();
                $filepath = $template_model->get_template_by_id($snippet->template_id)->filepath;
                $snippet->filepath = $filepath;
                $snippet->fields = $snippet->execute();                
                
                $result = Renderer::generate_html($snippet);
                $field->page_field_content = 
                        preg_replace('/\\[\\['.preg_quote($snippet_str).'\\]\\]/', 
                                $result, 
                                $field->page_field_content);
            }
        }
    }
   
} // End Welcome
