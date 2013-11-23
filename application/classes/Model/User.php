<?php
defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Database
{
    public function get_enabled_user_by_email_and_hashed_password($email, $hashed_password)
    {
        $query = DB::select('u.email', 'u.password', 'u.username', 'u.enabled', 'u.last_login')
            ->from(array('user', 'u'))
            ->where('u.email', '=', $email)
            ->where('u.password', '=', $hashed_password)
            ->where('u.enabled', '=', 1);

        $user = $this->execute_for_object($query);

        return $user;
    }

    public function get_user_by_email($email)
    {
        $query = DB::select('u.email', 'u.password', 'u.username', 'u.enabled', 'u.last_login')
            ->from(array('user', 'u'))
            ->where('u.email', '=', $email);

        $user = $this->execute_for_object($query);

        return $user;
    }

    public function check_user_has_role($email, $role_id)
    {
        $query = DB::select(DB::expr(1))
            ->from(array('user_role', 'ur'))
            ->where('ur.user_email', '=', $email)
            ->where('ur.role_id', '=', $role_id);

        $has_role = $this->execute_for_object($query);

        return $has_role;
    }

}