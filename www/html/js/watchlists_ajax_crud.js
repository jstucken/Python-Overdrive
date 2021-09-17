/*
* This script handles Ajax CRUD functionality
* Built from this tute:
* https://www.itechempires.com/2016/03/php-mysql-crud-create-read-update-delete-operations-using-jquery/
*/

// Add Record
function crudCreate() {
    // get values
	
	var watchlist_name = $("#watchlist_name").val();
	// check form is not blank
	if (watchlist_name == '') {
		alert('Please enter a watchlist name!');
		$("#watchlist_name").focus();
		return false;
	}
	
    // Add record
    $.post("/watchlists/watchlists_ajax_crud.php?action=create", {
        watchlist_name: watchlist_name
    }, function (data, status) {
		
		// if error message passed thru Ajax, display it as an alert
		var pos = data.indexOf('Error');
	
		// error message detected in Ajax response, so display it as an alert and dont proceed
		if (pos !== -1) {
			alert(data);
			return false;
		}
		
		// close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        crudRead();

        // clear fields from the popup
        $("#watchlist_name").val("");
    });
}

// READ records
function crudRead() {
    $.get("/watchlists/watchlists_ajax_crud.php?action=read", {}, function (data, status) {
        $(".records_content").html(data);
    });
}


/*
* Handles when user opens the update modal dialog.
* Updates a hidden form field which passes data along
*/
function openUpdate(id) {
	//alert("openUpdate() run on id: "+id);
	
	// backslashes are needed as escape characters to grab array elements
	// eg: $('#input\\[23\\]')
	
	$("#update_id").val(id);
	
	var existing_watchlist_name = $("#watchlist_name\\["+id+"\\]").val();
	$("#update_watchlist_name").val(existing_watchlist_name);
	$("#update_update_id").val(id);
	
}


function crudUpdate() {
	var id = $("#update_id").val();
	var watchlist_name = $("#update_watchlist_name").val();
	
	if (watchlist_name == '') {
		alert('Please enter a watchlist name!');
		$("#update_watchlist_name").focus();
		return false;
	}

    // update record
    $.post("/watchlists/watchlists_ajax_crud.php?action=update", {
        id: id,
        watchlist_name: watchlist_name
    }, function (data, status) {
		
		// if error message passed thru Ajax, display it as an alert
		var pos = data.indexOf('Error');
	
		// error message detected in Ajax response, so display it as an alert and dont proceed
		if (pos !== -1) {
			alert(data);
			return false;
		}
		
		
        // close the popup
        $("#update_record_modal").modal("hide");

        // read records again
        crudRead();

        // clear fields from the popup
        //$("#watchlist_name").val("");
    });
}


function crudDelete(id) {
    var conf = confirm("Are you sure you want to delete record "+id+" ?");
    if (conf == true) {
        $.post("/watchlists/watchlists_ajax_crud.php?action=delete", {
                id: id
            },
            function (data, status) {
                // reload Users by using crudRead();
                crudRead();
            }
        );
    }
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for future usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_first_name").val(user.first_name);
            $("#update_last_name").val(user.last_name);
            $("#update_email").val(user.email);
        }
    );
    // Open modal popup
    $("#crudUpdate_user_modal").modal("show");
}


$(document).ready(function () {
    // READ recods on page load
    crudRead(); // calling function
});