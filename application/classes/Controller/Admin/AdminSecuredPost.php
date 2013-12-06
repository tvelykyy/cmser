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
        $id = $this->request->post('id');
        $title = $this->request->post('title');

        if ($id)
        {
            $result = $this->model_block->edit($id, $title);
        } else
        {
            $result = $this->model_block->create($title);
        }

        $this->response->headers('Content-Type','application/json');
        echo json_encode($result);
    }

}
