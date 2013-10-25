<?php defined('SYSPATH') or die('No direct script access.');

class Snippet 
{
    private $class;
    private $method;
    private $filepath;
    private $params = array();
    
    function __construct($snippet_str)
    {
        /* [[class.method.template_id?param1=value1&param2=value2...]] */
        $snippet_parts = explode('?', $snippet_str);
        
        /* Parsing object and method. */
        $snippet_definition = explode('.', $snippet_parts[0]);
        $this->class = $snippet_definition[0];
        $this->method = $snippet_definition[1];

        $template_id = $snippet_definition[2];
        $this->filepath = Model_Template::get_template_by_id($template_id)->filepath;

        /* Parsing params */
        $params_parsed = explode('&', $snippet_parts[1]);
        
        foreach($params_parsed as $param)
        {
            $param_parsed = explode('=', $param);
            $this->params[$param_parsed[0]] = $param_parsed[1];
        }
    }

    public function generate_html()
    {
        $fields = $this->execute();
        $html = Generator_Html::generate_html_by_filepath_and_params($this->filepath, array('params' => $fields));

        return $html;
    }

    private function execute()
    {
        return call_user_func_array(array($this->class, $this->method), $this->params);
    }

} // End Snippet