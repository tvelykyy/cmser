<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AdminSecuredGet extends Controller
{
    private $generator_html;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
    }

    public function action_landing()
    {
        echo $this->generator_html->generate_html_by_path_and_params('admin/skeleton.html', array());
    }

    public function action_pages()
    {
        $limit = $this->get_query_value_or_default_value('limit', 2);
        $page_model = new Model_Page();
        $pages = $page_model->get_pages(0, $limit);

        echo $this->generator_html->generate_html_by_path_and_params(
            'admin/pages.html',
            array('title' => 'Site Pages', 'pages' => $pages)
        );
    }

    public function action_blocks()
    {
        $model_block = new Model_Block();
        $blocks = $model_block->get_all_blocks();

        echo $this->generator_html->generate_html_by_path_and_params(
            'admin/blocks.html',
            array('title' => 'Blocks', 'blocks' => $blocks)
        );
    }

    public function action_logout()
    {
        Auth::instance()->logout(TRUE);
        $this->redirect('admin');
    }

    private static function init_page($path, array $blocks)
    {
        $page = new stdClass();
        $page->path = $path;
        $page->fields = $blocks;
        return $page;
    }

    private function get_query_value_or_default_value($param, $default)
    {
        $query_param = $this->request->query($param);
        if($query_param == NUll)
        {
            $query_param = $default;
        }

        return $query_param;
    }

}
