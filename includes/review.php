<?php
    
require_once("initialize.php");

class Review extends DatabaseObject{

    protected static $table_name = "reviews";
    protected static $db_fields = array('id', 'product_id', 'reviewer', 'comment', 'created');
    public $id;
    public $product_id;
    public $reviewer;
    public $comment;
    public $created;

    public  function find_by_product_id($product_id){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE product_id = $product_id ORDER BY created DESC" );
    }

    public static function count_by_product_id($product_id){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name. " WHERE product_id = $product_id";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    } 

    public static function write_review($prod_id, $rev="", $comment=""){
        if(!empty($prod_id) && !empty($rev) && !empty($comment)){
           $review = new Review();
           $review->product_id = (int)$prod_id;
           $review->reviewer = $rev;
           $review->comment = $comment;
           $review->created = strftime("%Y-%m-%d %H:%M:%S", time());
           
           return $review;
        } else {
            return FALSE;
        }

    } 

    public static function find_reviews_on($product_id=0){
        global $database;
        $sql  = "SELECT * FROM " .Review::$table_name;
        $sql .= " WHERE product_id=" .$database->escape_value($product_id=0);
        $sql .= " ORDER BY created ASC";
        return Review::find_by_sql($sql);
    }

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . Review::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'product_id INT NOT NULL , ' .
            'reviewer  VARCHAR(50) NOT NULL, ' .
            'comment TEXT NOT NULL, ' .
            'created DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';
        Review::run_script($sql);
    }
}

Review::create_table();





?>

