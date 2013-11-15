<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_User_Test extends Model_Base_Test
{
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_User('test');
    }

    public function test_get_enabled_user_by_email_and_hashed_password()
    {
        /* When. */
        $user = $this->model->get_enabled_user_by_email_and_hashed_password('dummy@mail.com',
            '0f0a9a777952ceb5b629ec5a901df612c7bf2cd66a63ef2d80228d5557ca8dca');

        /* Then. */
        $this->assertNotEmpty($user);
        $this->assertEquals('dummy@mail.com', $user->email);
        $this->assertEquals('0f0a9a777952ceb5b629ec5a901df612c7bf2cd66a63ef2d80228d5557ca8dca', $user->password);
        $this->assertTrue($user->enabled == true);
        $this->assertEquals('Dummy', $user->username);
    }

}