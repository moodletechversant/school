<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB;

// Retrieve the selected option value
if(isset($_POST['option'])){
    $option1 = $_POST['option']; 
    //print_r($option1);exit();
    ?>

    <div class="table-responsive">
    <table class="table table-bordered text-center">  
			<tbody>
			
				<?php
                    $rec1=$DB->get_records_sql("SELECT * FROM {new_timetable_periods}  WHERE t_division=$option1");
                    $data = array();
                    
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
                        //print_r($value);exit();
                        
                        ?>
                        <tr>
                            <th class="align-middle" title="click to delete"> <?php echo $day; ?> </th>
                            <?php
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

                                ?>
                                <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13 titlebar" title="<?php echo $t_teacher; ?>"><?php echo $t_subject; ?></span>
                                    <div class="margin-10px-top font-size13"><?php  echo $from_time." to ".$to_time; ?> </div>
                                    <div class="margin-10px-top font-size13"><?php  echo "Teacher=".$t_teacher; ?> </div>
                               
                                </td>
                                <?php if($break_ftime != NULL) { ?>
                                            <td class="break-bg">
                                                <div class="margin-10px-top font-size14 break-color"><?php  echo $break_type; ?><br><?php  echo $break_ftime." to ".$break_ttime; ?></div>
                                            </td>
                                            
                                
                                <?php } 
                            } ?>
                         </tr>

                    <?php } ?>
			
			</tbody>
		
		</table>
        </div>
  
		
        <?php
	}
    else{
		
		echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
		
	}
	
?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/body.css">
  
  <style>
.center {
  margin: none;
  width: 100%;
  height: 10%;

  
}
.row {
  display: flex;
  justify-content: center;
  align-items: center;

}
.card-footer{
  width: 100%;
}
#bg1{
  background-color: #e6e6e6;
}
#col1{
  background-color: #17a2b8;
}

#col2{
  background-color: #28a745;
}
#col3{
  background-color: #ffc107;
}
#f1{
  background-color: #148c9f;
}
#f2{
  background-color: #23903c;
}
#f3{
  background-color: #e6ac00;
}
/* .demopara {
  display: none;
}
    
.demohead:hover + .demopara {
  display: block;
} */



    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>