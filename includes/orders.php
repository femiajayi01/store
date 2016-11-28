<?php
    
require_once("initialize.php");

class Order extends DatabaseObject{

    protected static $table_name = "orders";
    protected static $db_fields = array('id', 'order_number', 'customer_id', 'order_quantity', 'order_date', 'delivery_date', 'total_price');
    public $id;
    public $order_number;
    public $customer_id;
    public $order_quantity;
    public $order_date;
    public $delivery_date;
    public $total_price;

    public $order_items;


    public static function find_all_orders_by_customer($customer_id){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE customer_id = $customer_id ORDER BY order_date DESC" );
    }

    public static function find_all_orders(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " ORDER BY order_date DESC" );
    }

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . Order::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'order_number VARCHAR(10) NOT NULL, ' .
            'customer_id INT NOT NULL, ' .
            'order_quantity INT NOT NULL, ' .
            'order_date DATETIME NOT NULL, ' .
            'delivery_date DATETIME NOT NULL, ' .
            'total_price INT NOT NULL, ' .
            'PRIMARY KEY(id), ' .
            'UNIQUE KEY(order_number))';
        Order::run_script($sql);
    }
}

Order::create_table();




?>


