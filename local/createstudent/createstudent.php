<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/createstudent/createstudent_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/createstudent/createstudent.php');
$PAGE->set_context($context);
$strnewclass= get_string('studentcreation');
$PAGE->set_url('/local/createstudent/createstudent.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$mform=new createstudent_form();
echo $OUTPUT->header();



//hi
$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {

    //MOODLE USER CREATION IN CUSTOM STUDENT TABLE
    $stddata= new stdclass();
    $stddata->s_ftname=$formdata->fstname;
    $stddata->s_mlname=$formdata->midlname;
    $stddata->s_lsname=$formdata->lsname;
    $stddata->s_username=$formdata->username;
    $stddata->s_email=$formdata->email;
    $stddata->s_password=$formdata->password;
    $stddata->s_dob=$formdata->dob;
    $stddata->s_address=$formdata->address;
    $stddata->s_fname=$formdata->fname;
    $stddata->s_fno=$formdata->fno;
    $stddata->s_mname=$formdata->mname;
    $stddata-> s_mno=$formdata->mno;
    $stddata->s_gname=$formdata->gname;
    $stddata->s_gno=$formdata->gno;
    $stddata->s_bg=$formdata->bg;
    $stddata->s_gender=$formdata->gender;
    $stddata->s_district=$formdata->district;
    $stddata->s_class=$formdata->class;




//MOODLE USER CREATION IN USER TABLE
    $user = new stdClass();
    $user->confirmed = 1;
    $user->mnethostid = $CFG->mnet_localhost_id;
    $user->username =$formdata->username;
    $user->password = $formdata->password;
    $user->firstname = $formdata->fstname;
    $user->middlename = $formdata->mname;
    $user->lastname = $formdata->lsname;
    $user->email = $formdata->email;
    $user->phone1=$formdata->fno;
    $user->phone2=$formdata->mno;
    $user->address = $formdata->address;;
    $user->password = $formdata->password;
    $user->address=$formdata->address;
    // Create the user account in user table.
    user_create_user($user);
    //getting the last entered user detaile in user table
    $id= $DB->get_record_sql('SELECT id FROM mdl_user ORDER BY id DESC LIMIT 1');
    $stddata->user_id =$id->id;
    // Create the user account in custom student table.
    $DB->insert_record('student',$stddata);
    $urlto = $CFG->wwwroot.'/local/createstudent/createstudent.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();   
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('input[name="fstname"],input[name="midlname"],input[name="lsname"],input[name="fname"],input[name="mname"],input[name="gname"]').blur(function() {


var currVal = $(this).val();
$(this).val(currVal.charAt(0).toUpperCase() + currVal.slice(1).toLowerCase());


});

//text full lowercase
$('input[name="username"]').blur(function() {
var currVal = $(this).val();
$(this).val(currVal.toLowerCase());

});

//only alphabets
$('input[name="ftname"],input[name="mlname"],input[name="lsname"],input[name="fname"],input[name="mname"],input[name="gname"]').on("keydown", function(event){
	// Allow controls such as backspace, tab etc.
	var arr = [8,9,16,17,20,35,36,37,38,39,40,45,46];
	
	// Allow letters
	for(var i = 65; i <= 90; i++){
	arr.push(i);
	}
	
	// Prevent default if not in array
	if(jQuery.inArray(event.which, arr) === -1){
	event.preventDefault();
	}
	
	
	});



//only numeric value
$('input[name="fno"],input[name="mno"],input[name="gno"]').keypress
(
function(event)
{
    if (event.keyCode == 46 || event.keyCode == 8)
    {
    //do nothing
    }
    else 
    {
        if (event.keyCode < 48 || event.keyCode > 57 ) 
        {
            event.preventDefault();	
        }	
    }
}
);

    ///---------------------------------------------/////
    $(document).ready(function() {
    $("#id_academicyear").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_class").html(data);
        	}
        });
    }
    
   
});
});


$(document).ready(function() {
    $('#id_error_gender_male').remove();
    $('#id_error_gender_female').remove();

    $('#id_gender_female, #id_gender_male, #id_gender_others').on('change', function() {
        if ($('#id_gender_female, #id_gender_male, #id_gender_others').length > 0) {
            // $('#id_error_gender_others').remove();
        }
    });
});

</script>
<style>


    .container{
        padding-left : 20%;
        padding-top : 50px;
        padding-bottom : 50px;
        background-color : #72aacf;  
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);      
    }
    .heading{
        font-family : "Times New Roman", Times, serif;

    }
    .form-class{
        font-weight : bold; 
    }
    .form-control{
        border-radius : 15px;
        background-color : #FFFFFF;

    }
    .form-control:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    
    .custom-select{
        border-radius : 15px;
    }
    .custom-select:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    /* .btn{
        background-color : black;
    } */
    .fa-calendar{
        color : black;
    }  
    .btn-primary{
        background-color : #000000de;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:hover{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:focus{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: black;
    border-color: black;
    }
    .btn-secondary{
        border-radius : 15px;
    }
    .fdescription{
        display : none;
    }
    .footer-content-debugging{
        display : none;
    }


    </style>
    


