<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem(APPPATH.'views');
            $twig = new Twig_Environment($loader, array(
                'cache' => APPPATH.'views/cache',
            ));
            $template = $twig->loadTemplate('index.html');
            echo $template->render(array('hello' => 'This is Kohana Twig integration.'));
	}

} // End Welcome
