<?php

namespace Core\Model;

use Core\Database\MysqlDatabase;

class Table
{

    protected $table;
    protected $db;

    /**
     * It takes a database object as a parameter, and if the table property is null, it sets it to the name
     * of the class.
     * 
     * @param MysqlDatabase db This is the database connection.
     */
    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {

            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Model', '', $class_name));
        }
    }

    /**
     * It returns the result of a query that selects all columns from the table where the id is equal to
     * the id passed in.
     * 
     * @param id The id of the post you want to find
     * 
     * @return The query is being returned.
     */
    public function find($id)
    {
        return $this->query("
            SELECT *
            FROM " . $this->table . "
            WHERE id = ?
            ", [$id], true);
    }

    /**
     * It takes an array of fields and values, and returns a PDOStatement object
     * 
     * @param fields an array of fields to be inserted into the database.
     * 
     * @return The return value is the result of the query.
     */
    public function create($fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "`$k` = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->db->prepare("INSERT {$this->table} SET $sql_part", $attributes);
    }

    /**
     * It deletes a row from the database table where the ID is equal to the ID passed to the function
     * 
     * @param id The id of the record you want to delete.
     * 
     * @return The return value is the result of the query.
     */
    public function delete($id)
    {

        return $this->db->prepare("DELETE FROM {$this->table} WHERE id =?", $id);
    }

    /**
     * It takes an array of fields and values, and updates the database with the new values
     * 
     * @param id The id of the record you want to update
     * @param fields an array of fields to update
     * 
     * @return The return value is the result of the query.
     */
    public function update($id, $fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "`$k` = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sql_part = implode(', ', $sql_parts);
        return $this->db->prepare("UPDATE {$this->table} SET $sql_part WHERE id =?", $attributes);
    }

    /**
     * It takes a key and a value, and returns an array of all the records in the database, with the key as
     * the key and the value as the value
     * 
     * @param key The key to be used for the returned array
     * @param value The value of the option tag
     */
    public function list($key, $value)
    {
        $records = $this->all();
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }

    /**
     * It takes a SQL statement, an array of attributes, and a boolean value. If the array of attributes is
     * not empty, it returns the result of the prepare function of the database class, passing the SQL
     * statement, the array of attributes, the name of the entity class, and the boolean value. If the
     * array of attributes is empty, it returns the result of the query function of the database class,
     * passing the SQL statement, the name of the entity class, and the boolean value
     * 
     * @param statement The SQL statement to execute.
     * @param attributes the values to be inserted into the query
     * @param one if you want to return only one result, set it to true.
     * 
     * @return The query method returns the result of the query.
     */
    public function query($statement, $attributes = null, $one = false)
    {

        if ($attributes) {
            return $this->db->prepare($statement, $attributes, str_replace('Model', 'Entity', get_class($this)), $one);
        } else {
            return $this->db->query($statement, str_replace('Model', 'Entity', get_class($this)), $one);
        }
    }

    /**
     * This function returns all the rows from the table specified in the  property.
     * 
     * @return The query is being returned.
     */
    public function all()
    {
        return $this->query("
            SELECT *
            FROM " . $this->table . "");
    }
}
