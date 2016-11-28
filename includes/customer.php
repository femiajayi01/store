<?php
    
require_once("initialize.php");

class Customer extends DatabaseObject{

    protected static $table_name = "customers";
    protected static $db_fields = array('id', 'firstname', 'lastname', 'email', 'gender', 'mobile', 'state', 'address', 'password','dateRegistered');
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $gender;
    public $mobile;
    public $state;
    public $address;
    public $password;
    public $dateRegistered;

    public static function find_by_email($mail)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE email= '{$mail}' LIMIT 1";
        $result_array = Customer::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function find_by_email_except_current_id($mail, $id){
        $sql = "SELECT * FROM " . static::$table_name . " WHERE email= '{$mail}'  AND id <> '{$id}'";
        $result_array = Customer::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : FALSE;       
    }

    public function fullname(){
        if(isset($this->firstname) && isset($this->lastname)){
            return $this->firstname . " " . $this->lastname;
        } else {
            return "";
        }
    }

    public static function authenticate($email = "", $password = ""){
        global $database;
        $email = $database->escape_value($email);
        $password = $database->escape_value(hash('md5',$password));
        $sql = "SELECT * FROM customers ";
        $sql .= "WHERE email = '{$email}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    } 

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . Customer::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'firstname VARCHAR(50) NOT NULL, ' .
            'lastname  VARCHAR(50) NOT NULL, ' .
            'email VARCHAR(50) NOT NULL, ' .
            'gender VARCHAR(50) NOT NULL, ' .
            'mobile VARCHAR(50) NOT NULL, ' .
            'state VARCHAR(50) NOT NULL, ' .
            'address VARCHAR(80) NOT NULL, ' .
            'password VARCHAR(50) NOT NULL, ' .
            'dateRegistered  DATETIME NOT NULL, ' .
            'PRIMARY KEY(id), ' .
            'UNIQUE KEY(email))';
        Customer::run_script($sql);
    }
}

Customer::create_table();





?>

