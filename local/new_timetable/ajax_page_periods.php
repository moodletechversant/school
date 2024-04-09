
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php 

require(__DIR__.'/../../config.php');
global $DB;
//$context = context_system::instance();
require_login();

if(isset($_POST['period']) && isset($_POST['division'])){
    // $mform = $this->_form;
    $periods= $_POST['period'];
    $divisionn= $_POST['division'];
    
    $select_data='<div id="parent_container" class="parent_container">';

for ($i = 1; $i <= $periods; $i++) {
    $select_data .= '<h2>Period '. $i .'</h2>
    <table width="100%">
        <tr>
            <th>Period From</th>
            <td><input type="time" style="width:20%" class="form-control" id="fromtime_'.$i.'" name="fromtime_'.$i.'" value="00:00" required pattern=="(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)"/></td>
        </tr>
        <tr>
            <th>Period To</th>
            <td><input type="time" style="width:20%" class="form-control" id="totime_'.$i.'" name="totime_'.$i.'" value="00:00" required pattern=="(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)"/></td>
        </tr>';

    //get subject under the selected division
    $subjects = $DB->get_records('subject', array('sub_division' => $divisionn));
    $teachers = $DB->get_records('teacher_assign');
    $select_data .= '<tr>
        <th>Subject</th>
        <td><select name="subject_'.$i.'" class="form-select" id="subject_'.$i.'" style="width:30%"><option>select subject</option>';
    foreach ($subjects as $subject) {
        $select_data .= '<option value="'.$subject->course_id.'">'.$subject->sub_name.'</option>';
    }
    $select_data .= '</select></td></tr>
    <tr>
    <th>Teacher</th>
    <td><select name="teacher_'.$i.'" class="form-select" id="teacher_'.$i.'" style="width:30%">';
    foreach ($teachers as $teacher) {
    //    $select_data .= '<option value="'.$teacher->user_id.'">'.$teacher->user_id.'</option>';
    }
    $select_data .= '</select></td></tr>';

    // Add "Add Break" button/link
    $select_data .= '<tr>
        <td colspan="2">
            <a href="#" class="add_break" id="add_break_'.$i.'" data-id="'.$i.'">Add Break</a>
        </td>
    </tr></table>';

    // Add break dropdown initially hidden
    $select_data .= '<table id="break_row_'.$i.'" style="display:none;" width="100%"><tr>
        <th>Break Type</th>
        <td><select name="break_'.$i.'" style="width:50%" class="form-select" id="break_'.$i.'">
            <option value="">select</option>
            <option value="first break">First break</option>
            <option value="lunch break">Lunch break</option>
            <option value="second break">Second break</option>
            <option value="third break">Third break</option>
        </select></td>
    </tr>
    <tr>
        <th>Break from</th>
        <td><input type="time" style="width:30%" class="form-control" id="break_fromtime_'.$i.'" name="break_fromtime_'.$i.'" value="00:00:00" required pattern=="(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)"/></td>
    </tr>
    <tr>
        <th>Break To</th>
        <td><input type="time" style="width:30%" class="form-control" id="break_totime_'.$i.'" name="break_totime_'.$i.'" value="00:00:00" required pattern=="(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)"/></td>
    </tr>
    ';

    $select_data .= '</table>';
}

$select_data .= '</div>';



    echo $select_data;
}
?>
<script>

$(document).ready(function(){

    $(document).ready(function() {
    $('.add_break').click(function(e) {
        
        // $('#break_'+ periodId).empty();
        e.preventDefault();
        var periodId = $(this).data('id');
        $('#break_row_' + periodId).toggle();
        $('#break_'+ periodId). prop("selectedIndex",0)
        $('#break_fromtime_'+ periodId). val("00:00")
        $('#break_totime_'+ periodId). val("00:00")
    });


    $("#subject").change(function() {
        alert("df");
    });
   
        <?php 
        for ($i = 1; $i <= 1000; $i++) { ?>
            $("#subject_<?php echo $i; ?>").change(function() {
                var brand_id = $(this).val();

                            if (brand_id != "") {
                            $.ajax({
                            url: "test1.php",
                            data: { b_id: brand_id },
                            type: 'POST',
                            success: function(data) {
                            // alert(b_id);
                                $("#teacher_<?php echo $i; ?>").html(data);
                            }
                            });
                        }
            });

        <?php } ?>
});
});

</script>