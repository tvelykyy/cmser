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
        $url = $this->request->uri();
        $page_model = new Model_Page();
        $page = $page_model->get_page_by_uri($url);
        
        $page_model->get_all_pages_uri();

        $this->display_page($page);         
    }
    
    private function display_page($page) {
        echo $this->build_template($page['filepath'], $page['fields']);   
    }

    private function build_template($template, array $values) 
    {        
        $template = $this->twig->loadTemplate($template);
        return $template->render($values);
    }

} // End Welcome
