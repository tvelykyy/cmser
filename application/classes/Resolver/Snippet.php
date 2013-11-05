<?php defined('SYSPATH') or die('No direct script access.');

class Resolver_Snippet
{
    public static function resolve($blocks)
    {
        foreach($blocks as $block)
        {            
            preg_match_all('/\\[\\[(.*?)\\]\\]/', $block->page_field_content, $snippets);
            /* $snippets[0] returns match like this [[(.*?)]], we need (.*?)., so we take [1] */
            foreach($snippets[1] as $snippet_str)
            {
                $snippet = Snippet::from_string($snippet_str);
                $result = $snippet->generate_html();

                $block->page_field_content = preg_replace(
                    '/\\[\\['.preg_quote($snippet_str).'\\]\\]/',
                    $result,
                    $block->page_field_content
                );
            }
        }
    }
    
} // End Snippet