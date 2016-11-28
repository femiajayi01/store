<?php
    
require_once("initialize.php");

class OrderItems extends DatabaseObject{

    protected static $table_name = "orderItems";
    protected static $db_fields = array('id', 'order_id', 'product_title', 'quantity', 'unit_price', 'order_date');
    public $id;
    public $order_id;
    public $product_title;
    public $quantity;
    public $unit_price;
    public $order_date;

    public  function find_by_order_id($order_id){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE order_id = $order_id ORDER BY order_date DESC" );
    }

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . OrderItems::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'order_id INT NOT NULL, ' .
            'product_title VARCHAR(50) NOT NULL, ' .
            'quantity INT NOT NULL, ' .
            'unit_price INT NOT NULL, ' .
            'order_date DATETIME NOT NULL, ' .            
            'PRIMARY KEY(id)) ';
        OrderItems::run_script($sql);
    }
}

OrderItems::create_table();




?>
