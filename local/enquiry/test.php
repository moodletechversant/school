<?php
require(__DIR__ . '/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;
//$reply = new moodle_url('/local/enquiryreply/enquiryreply.php', ['id' => $id]);

if (isset($_POST['a_id'])) {
    $bid = $_POST['a_id'];
    $models = $DB->get_records_sql("SELECT * from {class} where academic_id='$bid'");
    if (!empty($models)) {
        $select_data = '<option value="" selected disabled>---- Select Class ----</option>';

        foreach ($models as $keys => $model) {
            $select_data .= '<option value =' . $model->id . '>' . $model->class_name . '</option>';
        }
        echo $select_data;
    } else {
        $select_data .= '<option value="">No Class found</option>';
        echo $select_data;
    }
}
if (isset($_POST['c_id'])) {
    $cid = $_POST['c_id'];
    if ($cid == 0) {
        $select_data .= '<option value="" selected disabled>---- Select Division----</option>';
    } else {
        $models = $DB->get_records_sql("SELECT * FROM {division} WHERE div_class = '$cid'");

        $select_data .= '<option value="" selected disabled>---- Select Division----</option>';

        if (empty($models)) {
            $select_data .= '<option value="" disabled>No divisions found</option>';
        } else {
            foreach ($models as $model) {
                $select_data .= '<option value="' . $model->id . '">' . $model->div_name . '</option>';
            }
        }
    }
    echo $select_data;
}

if (isset($_POST['d_id'])) {
    $did = $_POST['d_id'];

    $userid = $USER->id;

    $sid = $DB->get_record_sql("SELECT user_id FROM mdl_student WHERE user_id= '$userid '");
    $tid = $DB->get_record_sql("SELECT user_id FROM mdl_teacher WHERE user_id= '$userid '");

    if (!empty($tid) && $tid->user_id == $userid) {
        $sample = $DB->get_records_sql("SELECT user_id FROM {student_assign} WHERE s_division='$did'");

        $var = '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
             <div class="wrap-t">Date</div>
           </th>
           <th scope="col">
                 <div class="wrap-t">Student Name</div>
               </th>
             <th scope="col">
                 <div class="wrap-t">Subject</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Enquiry</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Action</div>
               </th>
             </tr>
           </thead>
           <tbody>';
        foreach ($sample as $values) {
            $data = $DB->get_records_sql("SELECT * FROM {enquiry} WHERE user_id=$values->user_id");

            foreach ($data as $value) {
                $user_ids = array();

                $user_ids[] = $value->user_id;
                //print_r($user_ids);exit();
                $user_ids_string = implode(',', $user_ids);
                //print_r($value );exit();
                $userdata = $DB->get_record_sql(" SELECT * FROM {student} WHERE user_id IN ($user_ids_string)");
                //print_r($userdata);exit();
                $user_id=$userdata->user_id;
                $name = $userdata->s_ftname;
                $date = $value->date;
                $subject = $value->subject;
                $enquiry = $value->enquiry;
                $viewReplyLink = $value->id ;
                $var .= '
                <tr>

                <td><div class="wrap-t">' . $date . '</div></td>
                <td><div class="wrap-t">' . $name . '</div></td>
                <td><div class="wrap-t">' . $subject . '</div></td>
                <td><div class="wrap-t">' . $enquiry . '</div></td>
                <td><div class="wrap-t"><a href="/school/local/enquiryreply/enquiryreply.php?id=' .$viewReplyLink. '"><button style="font-size: 14px; background-color: #5e4ec2 ; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; cursor: pointer;">Reply</button></a></div></td>
            </tr>';
            }
        }
        $var .= '</tbody>
        </table>
    </div>
    <!--<div class="table-pagination">
        <nav aria-label="Page navigation example">
        <ul class="pagination">    
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link active" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
        </nav>
    </div>-->';
    } else {
        echo "no details are found";
    }
    echo $var;
}
