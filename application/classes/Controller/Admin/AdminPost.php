<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AdminPost extends Controller
{
    private $generator_html;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->generator_html = new Generator_Html();
    }

    public function action_login()
    {
        $email = $this->request->post('email');
        $password = $this->request->post('password');

        if (Auth::instance()->login($email, $password, TRUE))
        {
            $this->redirect('sadmin/landing');
        }
        else
        {
            $this->redirect('admin');
        }
    }



}
