<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Db extends Auth
{
    const AUTH_COOKIE_NAME = 'authautologin';

    private $model_user;
    private $model_user_token;

    public function __construct($config = array(), Model_User $model_user = null, Model_UserToken $model_user_token = null)
    {
        parent::__construct($config);
        if (!isset($model_user))
        {
            $model_user = new Model_User();
        }
        $this->model_user = $model_user;

        if (!isset($model_user_token))
        {
            $model_user_token = new Model_UserToken();
        }
        $this->model_user_token = $model_user_token;
    }

    protected function _login($email, $password, $remember)
    {
        $hashed_password = $this->hash($password);
        $user = $this->model_user->get_enabled_user_by_email_and_hashed_password($email, $hashed_password);

        return $this->attempt_to_login($user, $remember);
    }

    protected function attempt_to_login($user, $remember)
    {
        if ($user !== NULL) {
            if ($remember === TRUE) {
                $token = $this->generate_and_save_token_for_user($user->email);
                $this->set_auth_cookie($token);
            }
            // Finish the login
            $this->complete_login($user);

            return TRUE;
        }

        return FALSE;
    }

    protected function generate_and_save_token_for_user($user_email)
    {
        $expires = time() + $this->_config['lifetime'];
        $encoded_user_agent = $this->get_encoded_user_agent();
        $token = $this->generate_token($user_email);

        $this->model_user_token->insert_token($user_email, $encoded_user_agent, $token, $expires);

        return $token;
    }

    protected function generate_token($unique_user_data)
    {
        return sha1((uniqid($unique_user_data, true)));
    }

    protected function set_auth_cookie($token)
    {
        Cookie::set(self::AUTH_COOKIE_NAME, $token, $this->_config['lifetime']);
    }

    public function get_user()
    {
        $user = parent::get_user(NULL);
        if ($user === NULL)
        {
            $user = $this->auto_login_by_cookie();
        }

        return $user;
    }

    public function auto_login_by_cookie()
    {
        if ($token = Cookie::get(self::AUTH_COOKIE_NAME))
        {
            $user_token = $this->model_user_token->get_by_token($token);

            if ($user_token != NULL && $user_token->user_agent === $this->get_encoded_user_agent())
            {
                $user = $this->set_updated_cookie($user_token);

                return $user;
            }
        }
        return NULL;
    }

    protected function set_updated_cookie($user_token)
    {
        $this->model_user_token->delete_by_id($user_token->id);

        $new_token = $this->generate_and_save_token_for_user($user_token->user_email);

        $this->set_auth_cookie($new_token);

        $user = $this->model_user->get_user_by_email($user_token->user_email);
        $this->complete_login($user);
        return $user;
    }

    private function get_encoded_user_agent()
    {
        return sha1(Request::$user_agent);
    }

    public function logout($destroy = FALSE)
    {
        if ($token = Cookie::get(self::AUTH_COOKIE_NAME))
        {
            Cookie::delete(self::AUTH_COOKIE_NAME);
            $this->model_user_token->delete_by_token($token);
        }

        return parent::logout($destroy);
    }

    public function password($username)
    {
        // TODO: Implement password() method.
    }

    public function check_password($password)
    {
        // TODO: Implement check_password() method.
    }

}