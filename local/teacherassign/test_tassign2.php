<?php
// Connect to the database
require(__DIR__.'/../../config.php');

// require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
// Mustache_Autoloader::register();

// $template = file_get_contents($CFG->dirroot . '/local/teacherassign/test_tassign.mustache');

require_login();
global $DB;

// Retrieve the selected option value
if(isset($_POST['option'])){
    $division = $_POST['option']; 
    $rec1=$DB->get_records_sql("SELECT * FROM {student_assign}  WHERE s_division=$division"); 

    $var .=' 
          <div class="form-wrap">
            <div class="cointainer">
              <div class="col-md-11 col-11 mx-auto col-lg-11">
                <div class="form-card card">  
                  
                  <div class="d-flex mb-3" style="align-items: center;">
                    <h4 class="mb-0"></h4>
                  </div>
        
                <p>click students name to view their learning path of the selected subject</p>
                  <div class="table-responsive custom-table">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">
                            <div class="wrap-t">Id</div>
                          </th>
                          <th scope="col">
                            <div class="wrap-t">Students Name</div>
                          </th>
                          <th scope="col">
                            <div class="wrap-t">Subject Taken</div>
                          </th>
                        </tr>
                      </thead>';

    foreach ($rec1 as $records) {
      // $studentnames = explode(',', $records->user_id);

      // foreach ($studentnames as $studentid) {

          $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$records->user_id");
          $id=$student->user_id;
          $name=$student->s_ftname.$student->s_mlname.$student->s_lsname;
          $var .='<tbody>
          <tr>
                  <td>
                    <div class="wrap-t">'.$id.'</div>
                  </td>
                  <td>
                <div class="wrap-t">'.$name.'</div>
                  </td>
                  <td>
                  <a href="/school/local/teacherassign/view_learningpath.php?id='.$id.'"><button class="action-table" style="width: auto; margin-right: inherit;">View Subject</button>
</a>
                  </td>
                </tr>
          
              </tbody>';
      }
    // }
    $var .='  </tbody>
    </table>
  </div>
  

</div>
</div>

</div>
</div>';
echo $var;
    }
    ?>
    
    
