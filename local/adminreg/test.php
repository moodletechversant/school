<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
require_login();



if (isset($_POST['admin_delete'])) {
    $admin_delete = $_POST['admin_delete'];
    //echo $delete;
        $DB->delete_records('admin_registration', array('id'=> $admin_delete));  
          
  }