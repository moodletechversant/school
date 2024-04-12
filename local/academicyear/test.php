<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
require_login();

if (isset($_POST['delete'])) {
    $bid = $_POST['delete'];
    // delete the record
   
    $deleted=$DB->delete_records('academic_year', array('id'=>$bid));

    if ($deleted) {
        echo 'success';
    } else {
        echo 'failure';
    }
}
?>