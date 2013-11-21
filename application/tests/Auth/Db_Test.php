<?php defined('SYSPATH') or die('No direct access allowed!');

class Auth_Db_Test extends Unittest_TestCase
{
    public function test_success_login_no_remember()
    {
        /* Given. */
        $dummy_user = $this->createDummyUser();
        $mocked_model_user = $this->create_user_model_mock_returning_dummy_user($dummy_user);
        $config = $this->config();
        $auth_db = new Auth_Db($config, $mocked_model_user, null);

        /* When. */
        $is_logged = $auth_db->login('dummy@mail.com', 'dummy_password');

        /* Then. */
        $this->assertEquals(true, $is_logged);
    }

    public function test_success_login_remember()
    {
        /* Given. */
        $dummy_user = $this->createDummyUser();
        $mocked_model_user = $this->create_user_model_mock_returning_dummy_user($dummy_user);
        $mocked_model_user_token = $this->create_model_user_token_mock();
        $config = $this->config();
        $auth_db = new Auth_Db($config, $mocked_model_user, $mocked_model_user_token);

        /* When. */
        $is_logged = $auth_db->login('dummy@mail.com', 'dummy_password', true);

        /* Then. */
        $this->assertEquals(true, $is_logged);
    }

    protected function createDummyUser()
    {
        $dummy_user = new stdClass();
        $dummy_user->email = 'dummy@mail.com';
        $dummy_user->password = 'dummy_password';
        $dummy_user->enabled = TRUE;

        return $dummy_user;
    }


    protected function create_user_model_mock_returning_dummy_user($dummy_user)
    {
        $mocked_model_user = $this->getMock('Model_User');
        $mocked_model_user->expects($this->once())
            ->method('get_enabled_user_by_email_and_hashed_password')
            ->will($this->returnValue($dummy_user));

        return $mocked_model_user;
    }

    protected function create_model_user_token_mock()
    {
        $mocked_model_user = $this->getMock('Model_UserToken');
        $mocked_model_user->expects($this->once())
            ->method('insert');

        return $mocked_model_user;
    }

    protected function config()
    {
        $config = array(
            'driver' => 'Db',
            'hash_method' => 'sha256',
            'hash_key' => 'key',
            'lifetime' => 1209600,
            'session_type' => Session::$default,
            'session_key' => 'auth_user',
        );
        return $config;
    }
}