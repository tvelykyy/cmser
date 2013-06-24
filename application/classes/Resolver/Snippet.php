<?php defined('SYSPATH') or die('No direct script access.');

class Resolver_Snippet
{
    
    public static function resolve($fields)
    {
        foreach($fields as $field)
        {            
            preg_match_all('/\\[\\[(.*?)\\]\\]/', $field->page_field_content, $snippets);
            /* $snippets[0] returns match like this [[(.*?)]], we need (.*?). */
            foreach($snippets[1] as $snippet_str)
            {
                $snippet = new Snippet($snippet_str);
                $template_model = new Model_Template();
                $filepath = $template_model->get_template_by_id($snippet->template_id)->filepath;
                $snippet->filepath = $filepath;
                $snippet->fields = $snippet->execute();                

                $result = Renderer::generate_html($snippet);
                $field->page_field_content = 
                        preg_replace('/\\[\\['.preg_quote($snippet_str).'\\]\\]/', 
                                $result, 
                                $field->page_field_content);
            }
        }
    }
    
} // End Snippet