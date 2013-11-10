<?php defined('SYSPATH') or die('No direct script access.');

class Snippet_Object
{
    private $model;
    private $method;
    private $template_id;
    private $params = array();
    private $generator_html;

    public static function from_string($str, $client_params = NULL)
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
            $param_and_value = explode('=', $pair);
            $key = $param_and_value[0];
            $value = $param_and_value[1];

            /* Initialize generic snippet params with client values. */
            if (preg_match('/^\{.*\}$/', $value) && count($client_params) > 0)
            {
                $value = $client_params[$key];
            }
            $params[$key] = $value;
        }

        return new Snippet_Object($model, $method, $template_id, $params);
    }

    public function __construct($model, $method, $template_id, $params)
    {
        $this->model = $model;
        $this->method = $method;
        $this->params = $params;
        $this->template_id = $template_id;
        $this->generator_html = new Generator_Html();
    }

    public function generate_html()
    {
        $fields = $this->execute_method();
        $html = $this->generator_html->generate_html_by_template_id_and_params($this->template_id, array('params' => $fields));

        return $html;
    }

    private function execute_method()
    {
        return call_user_func_array(array($this->model, $this->method), $this->params);
    }

    public function set_generator_html(Generator_Html $generator_html)
    {
        $this->generator_html = $generator_html;
    }

    public function set_model(Model_Page $model)
    {
        $this->model = $model;
    }

    public function get_model()
    {
        return $this->model;
    }

    public function get_params()
    {
        return $this->params;
    }

    public function get_template_id()
    {
        return $this->template_id;
    }

    public function get_method()
    {
        return $this->method;
    }


} // End Snippet