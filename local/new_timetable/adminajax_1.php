
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

if(isset($_POST['option1'])){
    $bid= $_POST['option1'];
    $models = $DB->get_records_sql("SELECT * from {class} where academic_id='$bid'");
    $select_data = '<option value="" selected disabled>---- Select Class ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->class_name.'</option>';
    }
    echo $select_data;
}

// Retrieve the selected option value
if(isset($_POST['option2'])){
$option2 = $_POST['option2'];
    if($option2==0){
        $select_data .= '<option value="" selected disabled>---- Select Division----</option>';
    }
    else{
    // Retrieve the corresponding option from a database or other data source
    $corresponding_option = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$option2'");

    // Generate the HTML for the corresponding option
    $html = '<option value="" selected disabled>---- Choose a division ----</option>';
    foreach ($corresponding_option as $keys =>$option) {
    $html .= '<option value="' . $option->id. '">' . $option->div_name . '</option>';
    }
}
// Return the HTML
echo $html;
}

// Retrieve the selected option value
if(isset($_POST['option'])){
    $option3 = $_POST['option']; 
    $period_id=$_POST['delete'];
    
    if( $period_id>0){
        // echo $period_id;exit();
        $DB->delete_records('new_timetable_periods', array('id'=> $period_id));
        $DB->delete_records('new_timetable', array('period_id'=> $period_id));
    }
    //print_r($option1);exit();
    ?>
    
    <div class="container">
        <div class="uk-overflow-auto">
            <table class="timetable uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-justify">
			<tbody>
			
				<?php
                    $rec1=$DB->get_records_sql("SELECT * FROM {new_timetable_periods}  WHERE t_division=$option3");
                    $data = array();
                    
                    foreach ($rec1 as $records) {
                        $val = $records->t_day;
                        //print_r($val);exit();
                        $div_id=$records->id;
                      
                        $value=$DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
                        $day=$value->days;
                        $daysid=$value->id;
                        $day_records= array();
                        $rec2=$DB->get_records_sql("SELECT * FROM {new_timetable} WHERE period_id = $div_id");
                        // print_r($rec2->t_subject);exit();
                        
                        ?>
                        <tr>
                            <th>
                                <div class="uk-tile uk-tile-secondary uk-padding-small uk-margin-small uk-text-center">
                                <div class="vertical-text">
                                    <h4> <?php echo $day; ?> </h4>
                                </div>
                                </div>
                            </th>
                            <?php
                            foreach ($rec2 as $records1) {
                                $period_id = $records1->period_id;
                                $id=$records1->id;
                                $from_time=$records1->from_time;
                                $to_time=$records1->to_time;
                                // print_r($records1->t_subject);exit();
                                //$t_subject1=$records1->t_subject;
                                $value2=$DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = $records1->t_subject");
                                //print_r($value2);exit();
                                $t_subject=$value2->sub_name;
                                $val1=$records1->t_teacher;
                                $value1=$DB->get_record_sql("SELECT t_fname FROM {teacher} WHERE user_id = $val1");
                                $t_teacher=$value1->t_fname;
                                $break_type=$records1->break_type;
                                $break_ftime=$records1->break_ftime;
                                $break_ttime=$records1->break_ttime;
                                $days_id=$records1->days_id;
                                ?>
                                <td>
                                    <div class="uk-tile uk-tile-primary uk-padding-small uk-margin-small">
                                    <h4 class="uk-margin-remove-bottom"><?php echo $t_subject; ?></h4>
                                    <p class="uk-margin-remove-top"><i><b>TIME:</b><?php  echo date('h:i A',$from_time)." to ".date('h:i A',$to_time); ?></i></p>
                                    <p><?php  echo "Teacher:".$t_teacher; ?> </p>
                                    </div>
                                </td>
                                <?php if($break_ftime != NULL) { ?>
                                <td class="break-bg">
                                    <div><?php  echo strtoupper($break_type); ?><br><b>TIME:</b><?php  echo date('h:i A',$break_ftime)." to ".date('h:i A',$break_ttime); ?></div>
                                </td>
                                <?php } 
                              
                            } ?>
                            <td>
                           
                                <a onclick="deletetimetable(<?php print_r($div_id); ?>)" href="#" class="action-table"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8 .784 8 .784h.006C8 .784 8 .784 8 .784h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
                   
                        </td>
                         </tr>
                    <?php } ?>
			</tbody>
		    </table>
        </div>
    </div>
    <?php
	}
    else{
		
		echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
		
	}
?>






