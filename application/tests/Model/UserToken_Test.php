<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_UserToken_Test extends Model_Base_Test
{
    protected $model;

    const ID = 1;
    const TOKEN = 'df4ed7297a2db98cec927647f46505d74ef75f8f';
    const USER_EMAIL = 'dummy@mail.com';
    const USER_AGENT = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    const EXPIRES = 1385740031;

    const TOKEN_NEW = 'token_new';
    const USER_EMAIL_NEW = 'user_email_new';
    const USER_AGENT_NEW = 'user_agent_new';
    const EXPIRES_NEW = 1381234567;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_UserToken('test');
        $this->runSchema('data.sql');
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

    public function test_delete_by_token()
    {
        /* Given. */
        $token_before_delete = $this->model->get_by_token(self::TOKEN);

        /* When. */
        $this->model->delete_by_token(self::TOKEN);

        /* Then. */
        $token_after_delete = $this->model->get_by_token(self::TOKEN);

        $this->assertNotEmpty($token_before_delete);
        $this->assertEquals(self::ID, $token_before_delete->id);
        $this->assertEmpty($token_after_delete);
    }

    public function test_delete_by_id()
    {
        /* Given. */
        $token_before_delete = $this->model->get_by_token(self::TOKEN);

        /* When. */
        $this->model->delete_by_id(1);

        /* Then. */
        $token_after_delete = $this->model->get_by_token(self::TOKEN);

        $this->assertNotEmpty($token_before_delete);
        $this->assertEquals(self::ID, $token_before_delete->id);
        $this->assertEmpty($token_after_delete);
    }

    public function test_insert_token()
    {
        /* Given. */

        /* When. */
        $this->model->insert(self::USER_EMAIL_NEW, self::USER_AGENT_NEW, self::TOKEN_NEW, self::EXPIRES_NEW);

        /* Then. */
        $actual_token = $this->model->get_by_token(self::TOKEN_NEW);
        $this->assertNotEmpty($actual_token);
        $this->assertNotEmpty($actual_token->id);
        $this->assertEquals(self::USER_EMAIL_NEW, $actual_token->user_email);
        $this->assertEquals(self::USER_AGENT_NEW, $actual_token->user_agent);
        $this->assertEquals(self::EXPIRES_NEW, $actual_token->expires);
    }


}