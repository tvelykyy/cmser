<?php defined('SYSPATH') or die('No direct access allowed!');

class Snippet_Resolver_Test extends Unittest_TestCase
{
    public function test_resolve_snippets()
    {
        /* Given. */
        $mocked_snippet_resolved = $this->getMock('Snippet_Resolver', array('generate_html_by_str_and_client_params'));
        $mocked_snippet_resolved->expects($this->once())
            ->method('generate_html_by_str_and_client_params')
            ->will($this->returnValue('super_html'));

        $block = new stdClass;
        $block->page_field_content = 'start [[snippet definition goes here]] end';
        $blocks = array($block);

        /* When. */
        $actual_blocks = $mocked_snippet_resolved->resolve_snippets($blocks);

        /* Then. */
        $this->assertEquals('start super_html end', $actual_blocks[0]->page_field_content);
    }

    public function test_resolve_snippets_with_empty_block_array()
    {
        /* Given. */
        $no_blocks = array();
        $snippet_resolver = new Snippet_Resolver();

        /* When. */
        $actual_blocks =$snippet_resolver->resolve_snippets($no_blocks);

        /* Then. */
        $this->assertEquals(array(), $actual_blocks);
    }
}