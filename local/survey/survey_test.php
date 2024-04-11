


<?php
require(__DIR__.'/../../config.php');
global $CFG, $USER, $DB;
$delete = new moodle_url('/local/survey/deletesurvey.php?id');

// Ensure the user is logged in
require_login();

// Get the current user's ID
$userid = $USER->id;

// Get the current timestamp and date
$current_time = time();
$current_date = strtotime(date('d-m-Y'));
// echo $current_date;
// Get the values from the form
if (!empty($_POST['year1']) || !empty($_POST['year2'])) {
    $year1 = $_POST['year1'];
    $year2 = $_POST['year2'];

    // Fetch academic year data based on the provided year
    $aca = $DB->get_record_sql("SELECT * FROM {academic_year} WHERE YEAR(FROM_UNIXTIME(start_year)) = ?", [$year1]);

    // Check if academic year data exists
    if ($aca) {
        $aca_id = $aca->id;

        // Fetch survey data based on the academic year
        $rec1 = $DB->get_records_sql("SELECT * FROM {customsurvey} WHERE academic_id = ?", [$aca_id]);
    }
}

// Initialize the HTML content variable
$html = '';

// Check if survey records were found
if (!empty($rec1)) {
    foreach ($rec1 as $record1) {
        $id = $record1->id;
        $surname = $record1->survey_name;
        $surveyfrom = $record1->survey_from;
        $surveyto = $record1->survey_to;

        // Format survey from and to dates
        $surveyfromFormatted = date("d-m-Y", $surveyfrom);
        $surveytoFormatted = date("d-m-Y", $surveyto);
        // Fetch survey questions
        $rec2 = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = ?", [$id]);

        // Initialize the survey questions variable
        $survey_questions = '';

        // Check if survey questions were found
        if (!empty($rec2)) {
            foreach ($rec2 as $record2) {
                $surquestion = $record2->survey_question;
                // Concatenate survey questions
                $survey_questions .= '<li>'.$surquestion.'</li>';
            }
        

        // Determine survey status
        if ($current_date >= $surveyfrom && $current_date <= $surveyto) {
            $status_message = $surveyfromFormatted . ' - ' . $surveytoFormatted;
            $status_color = 'green'; 
        }
        elseif ($current_date > $surveyto) {
            $status_message = 'This survey is no longer available';
            $status_color = '#867c7c'; 
            
        }
        elseif ($current_date < $surveyfrom) {
            $status_message = 'This will be available from ' . $surveyfromFormatted;
            $status_color = 'red';
        }
        
        // Generate HTML for each survey record
        $html .= '<div class="row mt-5" id="surveytable">
            <div class="col-12">
                <div class="note">
                    <h2 class="sub" style="text-decoration: underline;"><br>'.$surname.'<a href="editsurvey.php?id='.$id.'"><i class="fas fa-pencil-alt" style="font-size:20px"></i></a></h2>              
                    <p style="color: '.$status_color.';">'.$status_message.'</p>
                    <div class="hide" id="hide'.$id.'"> 
                        <ol>'.$survey_questions.'</ol>
                        <div class="button-container">
                            <a href="'.$delete.'='.$id.'" class="mr-3">
                                <button type="button" class="btn btn-outline-secondary del">Delete survey</button>
                            </a>
                        </div>
                    </div>
                    <div class="icon-d surveydrop" id="surveydrop'.$id.'">
                        <i class="fas fa-angle-down arrow transition-button" style="font-size:24px"></i>
                    </div>
                
                    </div>

               <br>
            </div>
            
        </div>';
    }}
}

// Wrap the HTML content with surrounding structure
$html = '<div class="form-wrap">
            <div class="container">
                <div class="col-md-10 col-10 mx-auto col-lg-8">
                    
                        <div class="row holiday-wrap">'.$html.'</div>
                    
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

        <script>
        $(".surveydrop").click(function(){
            var idValue =  $(this).attr("id");
            var hideid = $("#"+idValue).prev().attr("id");
            //alert(hideid)
            
            $("#"+hideid).toggle()
        })
        </script>
        ';

// Output the HTML
echo $html;
?>
