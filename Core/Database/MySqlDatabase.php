<?php

namespace Core\Database;

use App;
use \PDO;

class MySqlDatabase extends Database
{

    private $db_name;
    private $db_user;
    private $db_pwd;
    private $db_host;
    private $pdo;
    private static $_instance;

    public function __construct($db_name, $db_user = 'root', $db_pwd = '', $db_host = 'localhost')
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pwd = $db_pwd;
        $this->db_host = $db_host;
    }

    /**
     * If the instance is null, create a new instance of the class and return it. Otherwise, return the
     * existing instance.
     * 
     * @return The instance of the App class.
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * It creates a new PDO object and returns it.
     * 
     * @return The PDO object.
     */
    public function getPDO()
    {
        $pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host, $this->db_user, $this->db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $this->pdo = $pdo;
        return $pdo;
    }

    /**
     * It takes a SQL statement, a class name, and a boolean, and returns the result of the SQL statement
     * 
     * @param statement The SQL statement to be executed.
     * @param class_name The name of the class to use when fetching the data.
     * @param one if you want to return only one result, set it to true.
     * 
     * @return The query method returns the result of the query.
     */
    public function query($statement, $class_name = null, $one = false)
    {
        $req = $this->getPDO()->query($statement);
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {

            return $req;
        }
        if ($class_name === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }

    /**
     * It prepares a statement, executes it, and returns the result
     * 
     * @param statement The SQL statement to be prepared.
     * @param attributes an array of values to be inserted into the statement
     * @param class_name The name of the class to use to create the object.
     * @param one if you want to return only one result, set it to true.
     * 
     * @return The return value is the result of the PDOStatement::execute() method.
     */
    public function prepare($statement, $attributes, $class_name = null, $one = false)
    {
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attributes);
        if (
            strpos($statement, "UPDATE") === 0 ||
            strpos($statement, "INSERT") === 0 ||
            strpos($statement, "DELETE") === 0
        ) {

            return $res;
        }
        if ($class_name === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
}
