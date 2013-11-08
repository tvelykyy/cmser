<?php defined('SYSPATH') or die('No direct script access.');

class Generator_Html {

    private $twig;

    private $model_template;

    public function __construct(Model_Template $model_template = null) {
        if (!isset($model_template)) {
            $model_template = new Model_Template();
        }
        $this->model_template = $model_template;
        $this->initialize_twig();
    }

    private function initialize_twig()
    {
        /* Initialize Twig Template Engine. */
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => /*APPPATH.'views/cache'*/false,
            'autoescape' => false
        ));
        $this->twig->addGlobal('baseurl', '/cmser');
    }

    public function generate_html_by_template_id_and_params($template_id, array $params)
    {
        $template = $this->model_template->get_template_by_id($template_id);
        $filepath = $template->filepath;
        return $this->generate_html_by_filepath_and_params($filepath, $params);
    }

    public function generate_html_by_filepath_and_params($filepath, array $params)
    {
        return $this->build_template($filepath, $params);
    }

    private function build_template($template, array $values)
    {
        $template = $this->twig->loadTemplate($template);
        return $template->render($values);
    }

} // End Renderer