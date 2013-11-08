<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller 
{
    private $generator_html;

    private $snippet_resolver;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
        $this->snippet_resolver = new Snippet_Resolver();
    }

    public function action_index()
    {
        $uri = $this->request->uri();
        $model_page = new Model_Page();
        $page = $model_page->get_page_by_uri($uri);

        if ($page)
        {
            $page->fields = $this->snippet_resolver->resolve_snippets($page->fields);
            $page->fields = Helper_Array::convert_array_to_associative_array_for_page($page->fields);

            echo $this->generator_html->generate_html_by_filepath_and_params($page->filepath, $page->fields);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404();
        }
    }

} // End Welcome
