<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
            $url = $this->request->uri();
            $page_model = new Model_Page();
            echo 'url'.$url.'url';
//            $page = $page_model->get_page_by_url($url);
            
//            echo Controller_Welcome::build_template('index.html',
//                    array('hello' => 'This is Kohana Twig integration.'));            
	}
        
        private static function build_template($template, array $values) 
        {
            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem(APPPATH.'views');
            $twig = new Twig_Environment($loader, array(
                'cache' => APPPATH.'views/cache',
            ));
            $template = $twig->loadTemplate($template);
            return $template->render($values);
        }

} // End Welcome
