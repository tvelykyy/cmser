<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dispatcher extends Controller
{
    private $generator_html;

    private $snippet_resolver;

    private $model_page;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
        $this->snippet_resolver = new Snippet_Resolver();
        $this->model_page = new Model_Page();
    }

    public function action_index()
    {
        $uri = $this->request->uri();
        $query_params = $this->request->query_params();
        $page = $this->model_page->get_page_by_uri($uri);

        if ($page)
        {
            $page->fields = $this->snippet_resolver->resolve_snippets($page->blocks, $query_params);
            $page->fields = Helper_Array::convert_array_to_associative_array_for_page($page->blocks);

            echo $this->generator_html->generate_html_by_path_and_params($page->path, $page->blocks);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404('Page not found');
        }
    }

    public function set_model_page($model_page)
    {
        $this->model_page = $model_page;
    }

    public function set_snippet_resolver($snippet_resolver)
    {
        $this->snippet_resolver = $snippet_resolver;
    }

    public function set_generator_html($generator_html)
    {
        $this->generator_html = $generator_html;
    }



} // End Welcome
