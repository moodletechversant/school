<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.17/css/uikit.min.css" />
        <link rel="stylesheet" href="/school/local/css/style.css" />
</head>
<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB;
// Retrieve the selected option value
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

// Retrieve the selected option value
if(isset($_POST['option2'])){
$option2 = $_POST['option2'];

// Retrieve the corresponding option from a database or other data source
$corresponding_option = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$option2'");

// Generate the HTML for the corresponding option
$html = '<option value="" selected disabled>---- Choose a division ----</option>';
foreach ($corresponding_option as $keys =>$option) {
  $html .= '<option value="' . $option->id. '">' . $option->div_name . '</option>';
}

// Return the HTML
echo $html;
}

// Retrieve the selected option value
if(isset($_POST['option'])){
    $option3 = $_POST['option']; 
//timetable
    $rec1=$DB->get_records_sql("SELECT * FROM {new_timetable_periods}  WHERE t_division=$option3");
    $var =' <div class="container">
    <div class="uk-overflow-auto">
        <table class="timetable uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-justify">
        <tbody>';

    foreach ($rec1 as $records) {
        $val = $records->t_day;
        //print_r($val);exit();
        $div_id=$records->id;
        //print_r($div_id);exit();
        $value=$DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
        $day=$value->days;
        $daysid=$value->id;
        $day_records= array();
        $rec2=$DB->get_records_sql("SELECT * FROM {new_timetable} WHERE period_id = $div_id");



        $var.=' <tr>';
        foreach ($rec2 as $records1) {
            $period_id = $records1->period_id;
            $id=$records1->id;
            $from_time=$records1->from_time;
            $to_time=$records1->to_time;
            $t_subject1=$records1->t_subject;
            $value2=$DB->get_record_sql("SELECT * FROM {subject} WHERE id = $t_subject1");
            $t_subject=$value2->sub_name;
            $val1=$records1->t_teacher;
            $value1=$DB->get_record_sql("SELECT t_fname FROM {teacher} WHERE user_id = $val1");
            $t_teacher=$value1->t_fname;
            $break_type=$records1->break_type;
            $break_ftime=$records1->break_ftime;
            $break_ttime=$records1->break_ttime;
            $days_id=$records1->days_id;
            $var.='<td>

            <div class="uk-tile uk-tile-secondary uk-padding-small uk-margin-small uk-text-center">
            <h4>'.$day.'</h4>
            </div>
            <div class="uk-tile uk-tile-primary uk-padding-small uk-margin-small">
            <h4 class="uk-margin-remove-bottom" title="<?php echo $t_teacher; ?>">'.$t_subject.'</h4>
            <p class="uk-margin-remove-top"><i>'.$from_time.' to '.$to_time.'</i></p>
            <p>'.$t_teacher.'</p>
            </div>
            </td>';
            if($break_ftime != NULL){
                $var.=' <td class="break-bg">
                            <div class="margin-10px-top font-size14 break-color">'.$break_type.'<br>'.$break_ftime.' to '.$break_ttime.'</div>
                        </td>';
                    
    }
}

   
}
}
echo $var;
?>
