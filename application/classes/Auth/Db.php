<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Db extends Auth
{
    private $model_user;
    private $model_user_token;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->model_user = new Model_User();
        $this->model_user_token = new Model_UserToken();
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
                $token = $this->generate_and_save_token($user);
                $this->create_cookie_for_user($token);
            }
            // Finish the login
            $this->complete_login($user);

            return TRUE;
        }

        return FALSE;
    }

    protected function generate_and_save_token($user)
    {
        $expires = time() + $this->_config['lifetime'];
        $encoded_user_agent = $this->get_encoded_user_agent();
        $user_email = $user->email;
        $token = $this->generate_token($user_email);

        $this->model_user_token->insert_token($user_email, $encoded_user_agent, $token, $expires);

        return $token;
    }

    protected function generate_token($unique_user_data)
    {
        return sha1((uniqid($unique_user_data, true)));
    }

    protected function create_cookie_for_user($token)
    {
        Cookie::set('authautologin', $token, $this->_config['lifetime']);
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
        if ($token = Cookie::get('authautologin'))
        {
            // Load the token and user
            $user_token = $this->model_user_token->get_by_token($token);

            if ($user_token != NULL && $user_token->user_agent === $this->get_encoded_user_agent())
            {
                $this->model_user_token->delete_by_id($user_token->id);

                // Save the token to create a new unique token
                $user = $this->model_user->get_user_by_email($user_token->user_email);
                $new_token = $this->generate_token($user->email);
                $this->model_user_token->insert_token($user_token->user_email, $user_token->user_agent,
                    $new_token, time() + $this->_config['lifetime']);

                // Set the new token
                Cookie::set('authautologin', $new_token, $this->_config['lifetime']);

                // Complete the login with the found data
                $this->complete_login($user);

                // Automatic login was successful
                return $user;
            }
        }
        return NULL;
    }

    private function get_encoded_user_agent()
    {
        return sha1(Request::$user_agent);
    }

    public function logout($destroy = FALSE)
    {
        $this->_session->delete('auth_forced');

        if ($token = Cookie::get('authautologin'))
        {
            Cookie::delete('authautologin');
            // Clear the autologin token from the database
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