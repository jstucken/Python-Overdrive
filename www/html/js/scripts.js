
//
// begin select all/none checkboxes functionality
//
$("#select_all").change(function(){  //"select all" change
    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
});

//".checkbox" change
$('.checkbox').change(function(){
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(false == $(this).prop("checked")){ //if this item is unchecked
        $("#select_all").prop('checked', false); //change "select all" checked status to false
    }
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all").prop('checked', true);
    }
});
// end select all/none checkboxes functionality



// confirm delete student button
$(".delete_student_button").click(function() {
	
	// grab delete text on button title
	id_text = $(this).attr('title');
	//alert(id_text);
	
	if (confirm("Are you sure you want to "+id_text+" from the database and remove their files? This action cannot be undone.")) {
		return true;
	}
	else {
		return false;
	}
});


// confirm delete all students button
$("#delete_students").click(function() {
	
	if (confirm("Are you sure you want to delete all students from the database and remove all their files? This action cannot be undone.")) {
		
		window.location.href = '/reports/delete_report_data.php';
	}
	else {
		return false;
	}
});


// confirm delete class button
$(".delete_class_button").click(function() {
	// grab delete text on button title
	id_text = $(this).attr('title');
	//alert(id_text);
	
	if (confirm("Are you sure you want to "+id_text+"? Any students assigned to this class will have their class set to 'None' and you will need to reallocate them to a new class.")) {
		return true;
	}
	else {
		return false;
	}
});


// confirm delete car button
$(".delete_car_button").click(function() {
	
	// grab delete text on button title
	id_text = $(this).attr('title');
	//alert(id_text);
	
	if (confirm("Are you sure you want to "+id_text+" from the database? Any students allocated to this car will no longer be able to use it.")) {
		return true;
	}
	else {
		return false;
	}
});

// confirm delete class button
$("#delete_class_button").click(function() {
	
	// grab delete text on button title
	id_text = $(this).attr('title');
	//alert(id_text);
	
	if (confirm("Are you sure you want to "+id_text+" from the database? Any students allocated to this class will assigned to no class (they can then be assigned to another class if needed).")) {
		return true;
	}
	else {
		return false;
	}
});



// generic buttons can be used to send the user to a new page
// by passing the new page url within the title attribute
$(".generic_button").click(function() {
	
	var new_url = $(this).prop('title');
	//alert("new_url: "+new_url);
	window.location.href = new_url;
});



// Submits a form
// uses the form_id of the parent form where the button was clicked
$(".form_submit").click(function() {
	
	// get the form_id from this button which was clicked
	var form_id = $(this).parents('form').attr('id');
	
	//user_sql = $("#user_sql").val();
	//alert("user_sql: "+user_sql);

	// submit the form
	$("#"+form_id).submit();
	
	return true;
	
});


// Generates a random password based on a character set specified below
function generatePassword() {
    var length = 6,
        //charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        // available character set
        charset = "abcdefghijklmnopqrstuvwxyz",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

/*
* When the user clicks to generate a random password
* populate their password field with one
*/
$("#generatePassword").click(function() {
	
	random_pass = generatePassword();
	$("#user_password").val(random_pass);
	
	//alert(random_pass);
	return false;
});




/*
* Disables button when clicked eg to prevent duplicate clicks
* Useful on save buttons
*/
$("#add_student_form").submit(function( event ) {
    //alert( "Handler for .submit() called." );
    //$("#student_save_button").prop("value", "Input New Text");
    
    $("#student_save_button").val("Saving...");
    $("#student_save_button").attr("disabled", true);
    //event.preventDefault();
    $("#add_student_form").submit();
    
    //return false;
});


// Car add functionality
// if the user presses enter on the description field, it submits the form without breaking
$('#car_description').on('keypress', function (e) {
	 if(e.which === 13){
		//alert("ENTER PRESSED IN FIELD");
		$("#car_add_button").click();
		return false;
	 }
   });

// Submits the car_save form
// uses the form_id of the parent form where the button was clicked
$(".car_add_button").click(function() {
	
	// get the mac_address to add, off the buttons title attribute
	var key = $(this).attr('title');
	//alert("key:"+key);
	
	// put the car_mac into the form's hidden field
	$("#key").val(key);
	
	// submit the form to the car_add.php page
	$("#car_add_form" ).submit();
	
	return false;
	
});

/* To disable buttons whilst functionality is developed */
$(".coming_soon").click(function() {
	
	alert("Coming soon - this functionality is under development.");
	return false;
	
});
