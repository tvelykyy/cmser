<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_UserToken_Test extends Model_Base_Test
{
    protected $model;

    const TOKEN = 'df4ed7297a2db98cec927647f46505d74ef75f8f';
    const USER_EMAIL = 'dummy@mail.com';
    const USER_AGENT = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    const EXPIRES = 1385740031;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_UserToken('test');
    }

    public function test_get_by_token()
    {
        /* When. */
        $user_token = $this->model->get_by_token('df4ed7297a2db98cec927647f46505d74ef75f8f');

        /* Then. */
        $this->assertNotEmpty($user_token);
        $this->assertEquals(self::USER_EMAIL, $user_token->user_email);
        $this->assertEquals(self::TOKEN, $user_token->token);
        $this->assertEquals(self::USER_AGENT, $user_token->user_agent);
        $this->assertEquals(self::EXPIRES, $user_token->expires);
    }

    public function test_get_token_for_non_existent()
    {
        /* When. */
        $user_token = $this->model->get_by_token('invalid token');

        /* Then. */
        $this->assertEmpty($user_token);
    }

}