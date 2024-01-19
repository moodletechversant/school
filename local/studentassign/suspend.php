<?php
require_once dirname(__FILE__) . '/../../config.php';
global $DB,$CFG;
require_login();

if (isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];
    $class = $_POST['class'];
    $subjects = $DB->get_record_sql("SELECT {academic_year}.end_year FROM {academic_year} JOIN {class} ON {class}.academic_id={academic_year}.id WHERE {class}.id=$class");
    $end_year=$subjects->end_year;
    // Perform your database update based on the $action and $user_id
    // Update the 'timeend' field in the 'user_enrolments' table, for example
    // $cdatee = date(strtotime("-1 days"));
    
    $cdate = time(); 
    if ($action === 'close') {
        $DB->execute("UPDATE {user_enrolments} SET timeend = ? WHERE userid = ?", array($cdate, $user_id));
        
    } elseif ($action === 'open') {
        $DB->execute("UPDATE {user_enrolments} SET timeend = ? WHERE userid = ?", array($end_year, $user_id));
    
    }

    echo 'success';
} 
?>
