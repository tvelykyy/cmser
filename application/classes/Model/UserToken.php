<?php
defined('SYSPATH') or die('No direct script access.');

class Model_UserToken extends Model_Database
{
    public function insert($user_email, $user_agent, $token, $expires)
    {
        $query = DB::insert('user_token', array('user_email', 'user_agent', 'token', 'expires'))
            ->values(array($user_email, $user_agent, $token, $expires));

        $result = $query->execute($this->_db);

        return $result;
    }

    public function get_by_token($token)
    {
        $query = DB::select('id', 'user_email', 'user_agent', 'token', 'expires')
            ->from(array('user_token', 'u'))
            ->where('token', '=', $token);

        $user_token = $this->execute_for_object($query);

        return $user_token;
    }

    public function delete_by_id($id)
    {
        $query = DB::delete('user_token')
            ->where('id', '=', $id);

        $query->execute($this->_db);
    }

    public function delete_by_token($token)
    {
        $query = DB::delete('user_token')
            ->where('token', '=', $token);

        $query->execute($this->_db);
    }

}