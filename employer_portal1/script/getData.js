$(document).ready(function () {
    // code to get all records from table via select box
    $('.updatedetails').hide();
    $("#search-box").keyup(function(){
        $('.updatedetails').hide();
    });
    $(".search").click(function () {
        var username = $("#search-box").val();
        console.log("employer: " + username);
        var dataString = 'empusername=' + username;
        $.ajax({
            url: 'getEmployee.php',
            dataType: "json",
            data: dataString,
            cache: false,
            success: function (employeeData) {
                if (employeeData) {
//					$("#heading").show();		  
//					$("#no_records").hide();					
                    $("#username").val(employeeData.username);
                    $("#firstname").val(employeeData.firstname);
                    $("#lastname").val(employeeData.lastname);
                    $("#emailid").val(employeeData.emailid);
                    $("#mobilenumber").val(employeeData.mobilenumber);
                    $("#password").val(employeeData.password);
                    $('.updatedetails').show();
                    //$("#records").show();		 
                } else {
                    $("#heading").hide();
                    $("#records").hide();
                    $("#no_records").show();
                }
            }
        });
    });
    $("#delete").click(function () {
        var id = $("#users").val();
        console.log("deleteemployer: " + id);
        var dataString = 'empid=' + id;
        $.ajax({
            url: 'deleteEmployee.php',
            dataType: "html",
            data: dataString,
            cache: false,
            success: function (result) {
                if (result === "true") {
                    window.location.href = "http://localhost:8081/Sample-PHP-Project/employer_portal1/homepage.php?success=3"
                }

            }
        });
    });
});
