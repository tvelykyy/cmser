<?php defined('SYSPATH') or die('No direct script access.');

class Generator_Html {
    protected static $twig;

    private static function initialize()
    {
        /* Initialize Twig Template Engine. */
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
        self::$twig = new Twig_Environment($loader, array(
            'cache' => /*APPPATH.'views/cache'*/false,
            'autoescape' => false
        ));
        self::$twig->addGlobal("baseurl", '/cmser');
    }

    public static function generate_html_by_filepath_and_params($filepath, $params)
    {
        return self::build_template($filepath, $params);
    }

    private static function build_template($template, array $values)
    {
        if (self::$twig == null)
        {
            self::initialize();
        }
        $template = self::$twig->loadTemplate($template);
        return $template->render($values);
    }

} // End Renderer