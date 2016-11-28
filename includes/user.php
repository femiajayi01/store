<?php
    
require_once("initialize.php");  

class User extends DatabaseObject {

    protected static $table_name = "users";
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'created');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $created;

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public static function authenticate($username = "", $password = ""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    } 

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . User::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'username VARCHAR(50) NOT NULL, ' .
            'first_name  VARCHAR(50) NOT NULL, ' .
            'last_name VARCHAR(50) NOT NULL, ' .
            'password VARCHAR(50) NOT NULL, ' .
            'created  DATETIME NOT NULL, ' .
            'PRIMARY KEY(id), ' .
            'UNIQUE KEY(username))';
        User::run_script($sql);
        User::default_user();
    }

    public static function default_user(){
        $user = new User();
        $user->first_name = "Femi";
        $user->last_name = "Ajayi";
        $user->password = "admin";
        $user->username = "femmy@yahoo.com";
        $user->created = strftime("%Y-%m-%d %H:%M:%S", time());
        $sql = "SELECT * FROM " .static::$table_name. " WHERE username= '{$user->username}' LIMIT 1";
        if(!User::find_by_sql($sql))$user->save();
    }

    // Common Database Methods in the Parent class(DatabaseObject)


    
}

User::create_table();

?>


