<?php defined('SYSPATH') or die('No direct script access.');

class Snippet_Resolver
{

    public function resolve_snippets($blocks, $client_params = NULL)
    {
        $resolved_blocks = array();
        foreach($blocks as $block)
        {            
            $snippets_str = $this->get_snippets_str_from_page_block($block);

            foreach ($snippets_str as $snippet_str)
            {
                $snippet = Snippet_Object::from_string($snippet_str, $client_params);
                $html = $snippet->generate_html();

                $block->page_field_content = preg_replace(
                    '/\\[\\['.preg_quote($snippet_str).'\\]\\]/',
                    $html,
                    $block->page_field_content
                );
            }
            $resolved_blocks[] = $block;
        }
        return $resolved_blocks;
    }

    private function get_snippets_str_from_page_block($block)
    {
        $snippets_str_matches = null;
        preg_match_all('/\\[\\[(.*?)\\]\\]/', $block->page_field_content, $snippets_str_matches);

        $snippets_str = array();

        /* $snippets[0] returns match like this [[(.*?)]], we need (.*?)., so we take [1] */
        foreach ($snippets_str_matches[1] as $snippet_match)
        {
            $snippets_str[] = $snippet_match;
        }

        return $snippets_str;
    }
    
} // End Snippet