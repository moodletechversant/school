



<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB;
// Retrieve the selected option value
if(isset($_POST['option'])){
$option1 = $_POST['option'];

// Retrieve the corresponding option from a database or other data source
$corresponding_option = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$option1'");

// Generate the HTML for the corresponding option
$html = '<option value="" selected disabled>---- Choose a division ----</option>';
foreach ($corresponding_option as $option) {
  $html .= '<option value="' . $option->id. '">' . $option->div_name . '</option>';
}

// Return the HTML
echo $html;
}
?>
