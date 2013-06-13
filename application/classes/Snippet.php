<?php defined('SYSPATH') or die('No direct script access.');
 
class Snippet 
{
    protected $obj;
    protected $method;
    protected $params = array();
    
    function __construct($snippet_str)
    {
        /* [[class.method?param1=value1&param2=value2...]] */
        $snippet_parts = explode('?', $snippet_str);
        
        /* Parsing object and method. */
        $function_to_call = explode('.', $snippet_parts[0]);
        $class = $function_to_call[0];
        $this->obj = new $class;
        $this->method = $function_to_call[1];
        
        /* Parsing params */
        $params_parsed = explode('&', $snippet_parts[1]);
        
        foreach($params_parsed as $param)
        {
            $param_parsed = explode('=', $param);
            $this->params[$param_parsed[0]] = $param_parsed[1];
        }
        
    }
    
    public function execute()
    {
        return call_user_func_array(array($this->obj, $this->method), $this->params);
    }
} // End Snippet