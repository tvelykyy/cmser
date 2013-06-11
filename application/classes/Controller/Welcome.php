<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {
    protected $twig;
    
    function __construct(\Request $request, \Response $response) 
    {
        parent::__construct($request, $response);
        
        /* Initialize Twig Template Engine. */
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => /*APPPATH.'views/cache'*/false,
        ));
    }
    
    public function action_index()
    {
        $uri = $this->request->uri();
        $page_model = new Model_Page();
        $page = $page_model->get_page_by_uri($uri);

        $this->resolve_snippets($page->fields);
        $this->display_page($page);         
    }
    
    private function resolve_snippets($fields)
    {
        foreach($fields as $field)
        {
            preg_match_all('/\\[\\[(.*?)\\]\\]/', $field->page_field_content, $matches);
            foreach($matches[1] as $match)
            {
                $function_to_call = explode('.', $match);
                $class = $function_to_call[0];
                $method = $function_to_call[1];
                
                $obj = new $class;
                $result = $obj->$method();
                
                preg_replace('/[['.$match.']]/', (string) $result,  $field->page_field_content, 1);
            }
        }
    }
    
    private function display_page($page) {
        echo $this->build_template($page->filepath, 
                self::convert_field_array($page->fields));   
    }

    private function build_template($template, array $values) 
    {        
        $template = $this->twig->loadTemplate($template);
        return $template->render($values);
    }
    
    /**
     * Converts example array 
     * Array ( [0] => stdClass Object ( [title] => MAIN_CONTENT [page_field_content] => some text. ) )
     * to 
     * Array ( [MAIN_CONTENT] = > some text.
     * @param type $fields_array
     * @return null
     */
    private static function convert_field_array($fields_array)
    {
        if (is_array($fields_array))
        {
            $result_array = array();
            foreach ($fields_array as $field)
            {
                $result_array[$field->title] = 
                        $field->page_field_content;
            }
            return $result_array;
        }
        return NULL;
    }

} // End Welcome
