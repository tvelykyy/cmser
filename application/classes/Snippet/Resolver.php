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
                $html = $this->generate_html_by_str_and_client_params($client_params, $snippet_str);

                $block->block_content = preg_replace(
                    '/\\[\\['.preg_quote($snippet_str).'\\]\\]/',
                    $html,
                    $block->block_content
                );
            }
            $resolved_blocks[] = $block;
        }
        return $resolved_blocks;
    }

    private function get_snippets_str_from_page_block($block)
    {
        $snippets_str_matches = null;
        preg_match_all('/\\[\\[(.*?)\\]\\]/', $block->block_content, $snippets_str_matches);

        $snippets_str = array();

        /* $snippets[0] returns match like this [[(.*?)]], we need (.*?)., so we take [1] */
        foreach ($snippets_str_matches[1] as $snippet_match)
        {
            $snippets_str[] = $snippet_match;
        }

        return $snippets_str;
    }

    protected function generate_html_by_str_and_client_params($client_params, $snippet_str)
    {
        $snippet = new Snippet_Object($snippet_str, $client_params);
        $html = $snippet->generate_html();
        return $html;
    }

} // End Snippet