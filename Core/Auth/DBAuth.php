<?php

namespace Core\Auth;

use Core\Database\MySqlDatabase;

class DBAuth
{

    private $db;
    public function __construct(MySqlDatabase $db)
    {
        $this->db = $db;
    }

    /**
     * If the user is logged in, return the user's id. Otherwise, return false.
     * 
     * @return The user id of the logged in user.
     */
    public function getUserId()
    {
        if ($this->logged()) {

            return $_SESSION['auth'];
        }
        return false;
    }


    /**
     * If the user exists and the password is correct, then set the session variable and return true.
     * Otherwise, return false
     * 
     * @param username The username of the user you want to log in.
     * @param password The password to be hashed.
     * 
     * @return The user's id.
     */
    public function login($username, $password)
    {
        $user = $this->db->prepare('SELECT * FROM users WHERE username = ?', [$username], null, true);
        if ($user) {
            if ($user->password === sha1($password)) {
                $_SESSION['auth'] = $user->id;
                return true;
            }
        }
        return false;
    }

    /**
     * If the session variable 'auth' is set, return true, otherwise return false.
     */
    public function logged()
    {
        return isset($_SESSION['auth']);
    }
}
