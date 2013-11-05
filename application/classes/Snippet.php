<?php defined('SYSPATH') or die('No direct script access.');

class Snippet 
{
    private $model;
    private $method;
    private $filepath;
    private $params = array();
    private $model_template;

    public static function from_string($str)
    {
        /* [[model.method.template_id?param1=value1&param2=value2...]] */
        $tokens = explode('?', $str);

        /* Parsing object, method and template_id. */
        $model_method_template_id = explode('.', $tokens[0]);
        $model = new $model_method_template_id[0];
        $method = $model_method_template_id[1];

        $template_id = $model_method_template_id[2];

        /* Parsing params */
        $param_value_pairs = explode('&', $tokens[1]);

        foreach($param_value_pairs as $pair)
        {
            $param_value = explode('=', $pair);
            $params[$param_value[0]] = $param_value[1];
        }

        return new Snippet($model, $method, $template_id, $params);
    }

    public function __construct($model, $method, $template_id, $params)
    {
        $this->model = $model;
        $this->method = $method;
        $this->params = $params;

        $this->model_template = new Model_Template();
        $this->filepath = $this->model_template->get_template_by_id($template_id)->filepath;
    }

    public function generate_html()
    {
        $fields = $this->execute();
        $html = Generator_Html::generate_html_by_filepath_and_params($this->filepath, array('params' => $fields));

        return $html;
    }

    private function execute()
    {
        return call_user_func_array(array($this->model, $this->method), $this->params);
    }

    public function set_model_template($model_template)
    {
        $this->model_template = $model_template;
    }

} // End Snippet