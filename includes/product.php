<?php
    
class Product extends DatabaseObject
{
    public static $table_name = "products";
    protected static $db_fields = array('id', 'title', 'fileName', 'category_id', 'price', 'quantity', 'description', 'created');
    public $id;
    public $title;
    public $category_id;
    public $price;
    public $quantity;
    public $description;
    public $created;
    public $fileName;


    public $category;
    private $temp_path;
    protected $upload_dir = "images";
    public $errors = array();


    protected $upload_errors = array(
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    );

    public function attach_file($file)
    {
        // $name = $_FILES["file"]['tmp_name'];
        //  $ext = end((explode(".", $name)));

        $info = getimagesize($file['tmp_name']);
        $extension = image_type_to_extension($info[2]);
        if (!$file || empty($file) || !is_array($file)) {
            $this->errors[] = "No file was uploaded.";
            return FALSE;
        } else if ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors[$file['error']];
            return FALSE;
        } else {
            $this->temp_path = $file['tmp_name'];
            $this->title = $_POST['title'];
            //  $this->fileName     = basename($file['name']);
            $this->fileName = $this->title . '-' . date("Ymd") . $extension;
            $this->category_id = $_POST['category_id'];
            $this->price = $_POST['price'];
            $this->quantity = $_POST['quantity'];
            $this->description = $_POST['description'];
            $this->created = strftime("%Y-%m-%d %H:%M:%S", time());
            return TRUE;
        }

    }

    public function save()
    {
        if (isset($this->id)) {
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return FALSE;
            }

            if (empty($this->fileName) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return FALSE;
            }

            $target_path = SITE_ROOT . $this->upload_dir . DS . $this->fileName;

            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->fileName} already exists.";
                return FALSE;
            }
             if (move_uploaded_file($this->temp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->temp_path);
                    return TRUE;
                }
            } else {
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return FALSE;
            }

        }
    }

    public function destroy()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . $this->image_path();
            return unlink($target_path) ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    public function reviews(){
        return Review::find_reviews_on($this->id);
    }

    public function image_path()
    {
        return $this->upload_dir . DS . $this->fileName;
    }

    public function fetch_category()
    {
        if (isset($this->category)) return $this->category;
        $this->category = Category::find_by_id($this->category_id);
        return $this->category;
    }

    public static function find_all_by_date()
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " ORDER BY created DESC");
    }

    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS ' . Product::$table_name . '(' .
            'id INT(11) NOT NULL AUTO_INCREMENT, ' .
            'title VARCHAR(50) NOT NULL, ' .
            'fileName VARCHAR(50) NOT NULL, ' .
            'category_id  INT(11) NOT NULL, ' .
            'price VARCHAR(50) NOT NULL, ' .
            'quantity INT(11) NOT NULL, ' .
            'description TEXT NOT NULL, ' .
            'created  DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';

        Product::run_script($sql);
    }


    // Common Database Methods in the Parent class(DatabaseObject)


}

Product::create_table();

?>


