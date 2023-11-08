
<?php
// Connect to the database
require(__DIR__.'/../../config.php');



// Check if the option parameter exists
if (isset($_POST['option1'])) {
    // Get the selected academic year ID from the POST data
    $option1 = $_POST['option1'];

        $sql = "SELECT class_name, id FROM {class} WHERE academic_id = :option";
    $params = array('option' => $option1);
    $corresponding_option = $DB->get_records_sql($sql, $params);

    // Generate the HTML for the corresponding options
    $html = '<option value="" selected disabled>---- Choose a Class ----</option>';
    foreach ($corresponding_option as $keys =>$option) {
        $html .= '<option value="' . $option->id . '">' . $option->class_name . '</option>';
    }

    // Return the HTML response
    echo $html;
}
?>
