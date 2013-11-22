<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AdminGet extends Controller
{
    private $generator_html;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
    }

    public function action_login()
    {
        if (Auth::instance()->logged_in(1))
        {
            $this->redirect('sadmin/landing');
        }
        else
        {
            echo $this->generator_html->generate_html_by_path_and_params('admin/login.html', array());
        }
    }

}
