<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/division/div_edit_form.php');

global $DB,$USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Division";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/division/div_edit.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Division', new moodle_url($CFG->wwwroot.'/local/division/div_edit.php'));

echo $OUTPUT->header();
$mform = new edit_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/division/div_view.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
//print_r($formdata);exit();
     $divdata =  new stdclass();

     $divdata->id=$formdata->id;
     $divdata->div_class  = $formdata->class;
   
     $divdata->div_name = $formdata->dname;
     $divdata->div_strength = $formdata->strength;
     $divdata->div_bstrength = $formdata->bstrength;
     $divdata->div_gstrength = $formdata->gstrength;
     $divdata->div_description = $formdata->description;
    //  print_r($divdata->div_class);exit();


    $update=$DB->update_record('division',$divdata);


     $urlto = $CFG->wwwroot.'/local/division/div_view.php';
     redirect($urlto, 'Data Saved Successfully '); 

}


$mform->display();

echo $OUTPUT->footer();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    ///---------------------------------------------/////
    $(document).ready(function() {
    $("#id_academicyear").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test1.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_class").html(data);
        	}
        });
    }
    
   
});
});
   

$('input[name="strength"], input[name="bstrength"], input[name="gstrength"] ').keypress
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
$( "#id_bstrength, #id_gstrength" ).keyup(function() {
  $('#id_strength').val(tt)
  
  bz = $('#id_bstrength').val()
  gz = $('#id_gstrength').val()
  tot = $('#id_strength').val()
  var tt = parseInt(bz) + parseInt(gz)
  
  $('#id_strength').val(tt)

})




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