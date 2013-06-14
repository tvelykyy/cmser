<?php defined('SYSPATH') or die('No direct script access.');
 
class Renderer {
    protected static $twig;
    
    private static function initialize()
    {
        /* Initialize Twig Template Engine. */
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
        self::$twig = new Twig_Environment($loader, array(
            'cache' => /*APPPATH.'views/cache'*/false,
        ));
    }    
     
    public static function generate_html($page) 
    {
        return self::build_template($page->filepath, 
                self::convert_field_array($page->fields));   
    }

    public static function build_template($template, array $values) 
    {   
        if (self::$twig == null) 
        {
            self::initialize();
        } 
        $template = self::$twig->loadTemplate($template);
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
    /* TODO move this out. */
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

} // End Renderer