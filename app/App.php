<?php

use Core\Config;
use Core\Database\MySqlDatabase;

class App
{

    public $title = 'Site vitrine';
    private static $_instance;
    private $db_instance;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * It starts a session, loads the app's autoloader, and then loads the core's autoloader.
     */
    public static function load()
    {
        session_start();
        require ROOT . '/app/Autoloader.php';
        App\Autoloader::register();

        require ROOT . '/Core/Autoloader.php';
        Core\Autoloader::register();
    }

    /**
     * It takes a string as a parameter, and returns an instance of a class whose name is the string with
     * the first letter capitalized, and the word "Table" appended to it
     * 
     * @param name The name of the table you want to get.
     * 
     * @return A new instance of the class name that is being passed in.
     */
    public function getTable($name)
    {
        $class_name = '\\App\\Model\\' . ucfirst($name) . 'Model';
        return new $class_name($this->getDb());
    }

    /**
     * It returns a database connection object.
     * 
     * @return The database instance.
     */
    public function getDb()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');
        if (is_null($this->db_instance)) {
            $this->db_instance = new MySqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pwd'), $config->get('db_host'));
        }
        return $this->db_instance;
    }
}
