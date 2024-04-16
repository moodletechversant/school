<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
require_login();

//print_r($schoolid);exit();
if(isset($_POST['action'])){
    
  $schoolid=$_POST['schoolid'];
   $action= $_POST['action'];
// if($action!==NULL){
   if ($action === 'close') {
    $DB->execute("UPDATE {school_reg} SET sch_status = 1 WHERE id = $schoolid");
       
   } elseif ($action === 'open') {
    $DB->execute("UPDATE {school_reg} SET sch_status = 0 WHERE id = $schoolid");
   
   }
 
  echo 'success';
}
?>