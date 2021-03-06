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

        echo $this->prepare_json_response($result);
    }

    public function action_deleteblock()
    {
        $id_to_delete = $this->request->post('id');

        $this->model_block->delete_by_id($id_to_delete);
    }

}
