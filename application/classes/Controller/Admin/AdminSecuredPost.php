<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AdminSecuredPost extends Controller
{
    private $generator_html;
    private $model_block;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
        $this->model_block = new Model_Block();
    }

    public function action_block()
    {
        $title = $this->request->post('title');

        $this->model_block->create($title);
    }

}
