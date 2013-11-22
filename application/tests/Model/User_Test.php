<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_User_Test extends Model_Base_Test
{
    protected $model;

    const EMAIL = 'dummy@mail.com';
    const HASHED_PASSWORD = '0f0a9a777952ceb5b629ec5a901df612c7bf2cd66a63ef2d80228d5557ca8dca';
    const USER_NAME = 'Dummy';
    const ABRA_CADABRA_STRING = 'non-existent';
    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Model_User('test');
    }

    public function test_get_enabled_user_by_email_and_hashed_password()
    {
        /* When. */
        $user = $this->model->get_enabled_user_by_email_and_hashed_password(self::EMAIL, self::HASHED_PASSWORD);

        /* Then. */
        $this->assertDummyUser($user);
    }

    public function test_get_enabled_user_by_email_and_hashed_password_for_non_existent_user()
    {
        /* When. */
        $user = $this->model->get_enabled_user_by_email_and_hashed_password(self::ABRA_CADABRA_STRING,
            self::ABRA_CADABRA_STRING);

        /* Then. */
        $this->assertEmpty($user);
    }

    public function test_get_user_by_email()
    {
        /* When. */
        $user = $this->model->get_user_by_email(self::EMAIL);

        /* Then. */
        $this->assertDummyUser($user);
    }

    public function test_getuser_by_email_for_non_existent_user()
    {
        /* When. */
        $user = $this->model->get_user_by_email(self::ABRA_CADABRA_STRING);

        /* Then. */
        $this->assertEmpty($user);
    }

    public function test_check_has_role_positive()
    {
        /* When. */
        $has = $this->model->check_user_has_role(self::EMAIL, self::ADMIN_ROLE_ID);

        /* Then. */
        $this->assertNotEmpty($has);
    }

    public function test_check_has_role_negative()
    {
        /* When. */
        $has = $this->model->check_user_has_role(self::EMAIL, self::USER_ROLE_ID);

        /* Then. */
        $this->assertEmpty($has);
    }

    protected function assertDummyUser($user)
    {
        $this->assertNotEmpty($user);
        $this->assertEquals(self::EMAIL, $user->email);
        $this->assertEquals(self::HASHED_PASSWORD, $user->password);
        $this->assertTrue($user->enabled == true);
        $this->assertEquals(self::USER_NAME, $user->username);
    }

}