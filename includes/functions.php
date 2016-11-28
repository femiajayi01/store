<?php
    
function strip_zeros_from_date($marked_string = ""){
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    //then remove any remaining marks
    $cleaned_string = str_replace('*','', $no_zeros);
    return $cleaned_string;
}

function redirect_to($location = NULL){
    if ($location != NULL){
        header("Location: {$location}");
        exit;
    }
}

function output_message($message = ""){
    if (!empty($message)){
        return "<p class = \"message\">{$message}</p>";
    } else {
        return "";
    }
}

function __autoload($class_name) {
    $class_name = strtolower($class_name);
   // $path = "../includes/{$class_name}.php";
    $path = LIB_PATH.DS."{$class_name}.php";
    if (file_exists($path)){
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found. ");
    }
}

function include_layout_template($template= "") {
    include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function log_action($action, $message=""){
    $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
 //   $new = file_exists($logfile) ? FALSE : TRUE;
    if($handle = fopen($logfile, 'a')){ // append
        $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = "{$timestamp} | {$action}: {$message}\n";
        fwrite($handle, $content);
        fclose($handle);
        //if ($new){ chmod($logfile, 0755); }
    } else {
        echo "Could not open log file for writing.";
    }
    
}

function datetime_to_text($datetime=""){
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d %Y at %I:%M %p", $unixdatetime);
}

function date_to_text($datetime=""){
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d %Y", $unixdatetime);
}

function time_to_text($datetime=""){
    $unixdatetime = strtotime($datetime);
    return strftime("%I:%M %p", $unixdatetime);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function is_post(){
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function ensure_login($session){
        if (!isset($_SERVER['X_HTTP_ORIGINAL_URL']))
        $ReturnURL = $_SERVER['X_HTTP_ORIGINAL_URL'];
        else
            $ReturnURL = $_SERVER['REQUEST_URI']; 
        $ReturnURL = $_SERVER['URL'];

        if (!$session->is_logged_in()) redirect_to('login.php?returnurl='.$ReturnURL);
}

?>


