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

        if ($user !== NULL)
        {
            if ($remember === TRUE)
            {
                // Token data
                $user_email = $user->email;
                $expires = time() + $this->_config['lifetime'];
                $user_agent = sha1(Request::$user_agent);
                $token = sha1((uniqid($user_email, true)));

                $this->model_user_token->insert_token($user_email, $user_agent, $token, $expires);

                // Set the autologin cookie
                Cookie::set('authautologin', $token, $this->_config['lifetime']);
            }

            // Finish the login
            $this->complete_login($user);

            return TRUE;
        }

        return FALSE;
    }

    public function get_user()
    {
        $user = parent::get_user(NULL);

        if ($user === NULL)
        {
            // check for "remembered" login
            if (($user = $this->auto_login_by_cookie()) === FALSE)
                return NULL;
        }

        return $user;
    }

    public function auto_login_by_cookie()
    {
        if ($token = Cookie::get('authautologin'))
        {
            // Load the token and user
            $user_token = $this->model_user_token->get_by_token($token);

            if ($user_token != NULL)
            {
                if ($user_token->user_agent === sha1(Request::$user_agent))
                {
                    $this->model_user_token->delete_by_id($user_token->id);

                    // Save the token to create a new unique token
                    $user = $this->model_user->get_user_by_email($user_token->email);
                    $this->model_user_token->insert_token($user_token->email, $user_token->user_agent,
                        sha1((uniqid($user->user_email, true))), time() + $this->_config['lifetime']);

                    // Set the new token
                    Cookie::set('authautologin', $user_token->token, time() + $this->_config['lifetime']);

                    // Complete the login with the found data
                    $this->complete_login($user);

                    // Automatic login was successful
                    return $user;
                }
            }
        }
        return FALSE;
    }

    public function logout($destroy = FALSE)
    {
        // Set by force_login()
        $this->_session->delete('auth_forced');

        if ($token = Cookie::get('authautologin'))
        {
            // Delete the autologin cookie to prevent re-login
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