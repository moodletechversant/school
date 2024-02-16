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

    if($formdata->existing == 'no'){
        $parentdata= new stdclass();
        $parentdata->firstname=$formdata->p_fstname;
        $parentdata->surname=$formdata->p_surname;
        $parentdata->lastname=$formdata->p_lsname;
        $parentdata->username=$formdata->p_username;
        $parentdata->email=$formdata->p_email;
        $parentdata->password=$formdata->p_password;
        // $parentdata->address=$formdata->p_address;
        $parentdata->phone1=$formdata->p_mno;
        
        if(isset($parentdata->firstname)&&isset($parentdata->surname)&&isset($parentdata->lastname)&&isset($parentdata->username)&&isset($parentdata->password)&&isset($parentdata->email)&&isset($parentdata->phone1)){
        user_create_user($parentdata);
        //print_r($parentdata->firstname);exit();
        $id1= $DB->get_record_sql('SELECT id FROM mdl_user ORDER BY id DESC LIMIT 1');
        $parentdata_user= new stdclass();
        $parentdata_user->user_id =$id1->id;
        $parentdata_user->child_id =$id->id;

        // Create the user account in custom student table.
        $DB->insert_record('parent',$parentdata_user);
        }
    }
    else{
        $parentdata_user->user_id=$formdata->subselect;
        $parentdata_user->child_id =$id->id;
        $DB->insert_record('parent',$parentdata_user);
        
    }
    $urlto = $CFG->wwwroot.'/local/createstudent/createstudent.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();   
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('input[name="fstname"],input[name="midlname"],input[name="lsname"],input[name="fname"],input[name="mname"],input[name="gname"],input[name="p_fstname"],input[name="p_surname"],input[name="p_lsname"]').blur(function() {


var currVal = $(this).val();
$(this).val(currVal.charAt(0).toUpperCase() + currVal.slice(1).toLowerCase());


});

//text full lowercase
$('input[name="username"]').blur(function() {
var currVal = $(this).val();
$(this).val(currVal.toLowerCase());

});

//only alphabets
$('input[name="ftname"],input[name="mlname"],input[name="lsname"],input[name="fname"],input[name="mname"],input[name="gname"],input[name="p_fstname"],input[name="p_surname"],input[name="p_lsname"]').on("keydown", function(event){
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
$('input[name="fno"],input[name="mno"],input[name="gno"],input[name="p_mno"]').keypress
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

//--------Function for parent section--------//

function showSubDropdown(selectElement) {
        //var subselectElement = document.getElementById('id_subselect');
        //var radioElement = document.getElementById('fgroup_id_existing_group');
        var suboptionDiv = document.querySelector('.suboption');
        var parentDetailsDiv = document.querySelector('.parent_details');


        if (selectElement.value == 'yes') {
            //subselectElement.style.display = 'block';
            //radioElement.style.display = 'none';
            suboptionDiv.style.display = 'block';
            parentDetailsDiv.style.display = 'none';

        } else {
            //subselectElement.style.display = 'none';
            suboptionDiv.style.display = 'none';
            parentDetailsDiv.style.display = 'block';

        }
    }

//--------End of function parent section--------//

//--------Ajax code for autocomplete--------//

$(document).ready(function() {
    $("#id_subselect").change(function() {
        var brand_id = $(this).val();
        if(brand_id != ""){
            $.ajax({
                url:"test.php",
                data:{p_id:brand_id},
                type:'POST',
                success: function(data){
                    $("#details_container").html(data);
                }
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    $("#id_submitbutton").click(function() {
        var radioButton = document.getElementById("id_existing_yes");
    if (radioButton.checked) {
        var selectedValue = $("#id_subselect").val();

if (selectedValue == 0) {
    alert("No option has been selected.");
    event.preventDefault();
} 
  } 
   
  });
    document.querySelector("input[type=submit]").addEventListener("click", function(event) {
        var radioValue = document.querySelector('input[name="existing"]:checked').value;
        var formValid = true;

        // Checking form elements based on radio button selection
        if (radioValue === 'no') {
            var parentFirstName = document.querySelector('input[name="p_fstname"]').value;
            var parentSurname = document.querySelector('input[name="p_surname"]').value;
            var parentLastName = document.querySelector('input[name="p_lsname"]').value;
            var parentMobileNo = document.querySelector('input[name="p_mno"]').value;
            var parentEmail = document.querySelector('input[name="p_email"]').value;
            var parentUsername = document.querySelector('input[name="p_username"]').value;
            var parentPassword = document.querySelector('input[name="p_password"]').value;

            // Check if any of the fields are empty
            if (parentFirstName === '' || parentSurname === '' || parentLastName === '' || parentMobileNo === '' || parentEmail === '' || parentUsername === '' || parentPassword === '') {
                formValid = false;
            }
        } 
        
        // Show alert if form is invalid
        if (!formValid) {
            alert("Please fill all the form elements.");
            event.preventDefault(); // Prevent form submission
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
    
//--------End of ajax code--------//

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
    


