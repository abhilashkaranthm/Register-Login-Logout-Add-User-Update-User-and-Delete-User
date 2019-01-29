<?php
// Initialize the session
error_reporting(0);
session_start();
include_once("config.php");
$username = $firstname = $lastname = $emailid = $mobilenumber = $password = $confirm_password = "";
$username_err = $firstname_err = $lastname_err = $emailid_err = $mobilenumber_err = $password_err = $confirm_password_err = "";
//fetching data in descending order (lastest entry first)
$sql  = $pdo->prepare("SELECT * FROM employer ORDER BY id ASC");
$sql->execute();

$sqldelete = "SELECT * FROM employer";
$stmtdelete = $pdo->prepare($sqldelete);
$stmtdelete->execute();
$usersdelete = $stmtdelete->fetchAll();

$sqlsearch = "SELECT * FROM employer";
$sqlsearch = $pdo->prepare($sqldelete);
$sqlsearch->execute();
$usersearch = $sqlsearch->fetchAll();


if ( isset($_GET['success']) && $_GET['success'] == 1 )
{
     $msg = "Data Updated Successfully";
}

if ( isset($_GET['success']) && $_GET['success'] == 2 )
{
     $msg = "User Added Successfully";
}

if ( isset($_GET['success']) && $_GET['success'] == 3 )
{
     $msg = "User Deleted Successfully";
}

$username = "";
$firstname = "";
$lastname = "";
$emailid = "";
$mobilenumber = "";
$password = "";


function getPosts()
{
    $posts = array();
    
    $posts[1] = $_POST['username'];
    $posts[2] = $_POST['firstname'];
    $posts[3] = $_POST['lastname'];
    $posts[4] = $_POST['emailid'];
    $posts[5] = $_POST['mobilenumber'];
    $posts[6] = $_POST['password'];
    
    return $posts;
}

function getPostsdelete()
{
    $postsdelete = array();
    
    $postsdelete[1] = $_POST['username'];
    return $postsdelete;
}

if(isset($_POST['add']))
{
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id,username,firstname,emailid,mobilenumber FROM employer WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            //$stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
            //$stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
            //$stmt->bindParam(":emailid", $param_emailid, PDO::PARAM_STR);
            //$stmt->bindParam(":mobilenumber", $param_mobilenumber, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            //$param_firstname = trim($_POST["firstname"]);
            //$param_lastname = trim($_POST["lastname"]);
            //$param_emailid = trim($_POST["emailid"]);
            //$param_mobilenumber = trim($_POST["mobilenumber"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                    $firstname = trim($_POST["firstname"]);
                    $lastname = trim($_POST["lastname"]);
                    $emailid = trim($_POST["emailid"]);
                    $mobilenumber = trim($_POST["mobilenumber"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO employer (username,firstname,lastname,emailid,mobilenumber, password) VALUES (:username,:firstname,:lastname,:emailid,:mobilenumber, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
            $stmt->bindParam(":emailid", $param_emailid, PDO::PARAM_STR);
            $stmt->bindParam(":mobilenumber", $param_mobilenumber, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_emailid = $emailid;
            $param_mobilenumber = $mobilenumber;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                Header( 'Location: homepage.php?success=2' );
                
                //header("location: homepage.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
if(isset($_POST['search']))
{
    $data = getPosts();
    
   if(empty($data[1]))
  {
        echo 'Enter The Username To Search';
    }  else {
        
       $searchStmt = $pdo->prepare('SELECT * FROM employer WHERE id = :id');
        $searchStmt->execute(array(':id'=> $data[1]));
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
           {
                echo 'No Data For This Username';
            }
            
           $username   = $user[1];
           $firstname = $user[2];
           $lastname = $user[3];
           $emailid   = $user[4];
           $mobilenumber   = $user[5];
           $password   = $user[6];
        }
        
    }
}



//Update Data

if(isset($_POST['update']))
{
   $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) || empty($data[6]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $pdo->prepare('UPDATE employer SET firstname = :firstname,lastname=:lastname, emailid=:emailid, mobilenumber=:mobilenumber, password=:password  WHERE username = :username');
        $updateStmt->execute(array(':username'=> $data[1], ':firstname'=> $data[2], ':lastname'=> $data[3], ':emailid'=> $data[4], ':mobilenumber'=> $data[5], ':password'=> password_hash($data[6], PASSWORD_DEFAULT)));
        
        if($updateStmt)
        {
                Header( 'Location: homepage.php?success=1' );
        }
        
    }
        
    }

if(isset($_POST['delete']))
{
    
    $datadelete = $_POST['username'];
    
    if(empty($datadelete))
    {
        echo 'Enter The Username To Delete';
    }  else {
        
        $deleteStmt = $pdo->prepare('DELETE FROM employer WHERE id = :id');
        $deleteStmt->execute(array(
                    ':id'=> $datadelete
        ));
        
        if($deleteStmt)
        {
            
                Header( 'Location: homepage.php?success=3' );
        }
        
    }
}
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        
         .container {
    margin: auto;
    padding: 20px 0px 0px;
}
footer{
    
    font-size: 20px
}
table,tr,th,td{
    
    font-size: 20px;
    border: 1px solid black;
}
th, td {
    padding: 15px;
}
.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px opx;
}

.header a {
  float: left;
  color: #f9f9f9;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 15px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: auto ; /* 5% from the top, 15% from the bottom and centered */
    width: 40%; /* Could be more or less, depending on screen size */
    padding: 16px;
    text-align: left;
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
.container {
    background-color: #fefefe;
    padding: 15px;
    text-align: left;
}
    </style>
</head>
<body>
    <div class="header">
        <img src="images/nfaktor_logo.png" align="left">
        <a href="logout.php" class="btn btn-danger pull-right" >Logout</a><br><br>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Nfaktor</h1>
        
    </div>
    <p>
        <span id="msg"><?php echo $msg; ?></span><br><br>
        <!--<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>-->
        
        <button onclick="document.getElementById('id01').style.display='block'" class="btn btn-primary ">Add User</button>
        <button onclick="document.getElementById('id02').style.display='block'" class="btn btn-primary ">Update User</button>
        <button onclick="document.getElementById('id03').style.display='block'" class="btn btn-primary ">Delete User</button>
        
        
    </p>
    
<!-------------------------------------------Add user------------------------------------------------------------------------->
<div id="id01" class="modal">
    <div class="modal-content animate">
       <form action="/action_page.php">
    <div>
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Add User">&times;</span>
    </div>
  </form>
      <h2>Add a User</h2>
        <p>Please fill this form to add a user.</p>
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>   
            
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>  
            
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($emailid_err)) ? 'has-error' : ''; ?>">
                <label>Email ID</label>
                <input type="text" name="emailid" class="form-control" value="<?php echo $emailid; ?>">
                <span class="help-block"><?php echo $emailid_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($mobilenumber_err)) ? 'has-error' : ''; ?>">
                <label>Mobile Number</label>
                <input type="text" name="mobilenumber" class="form-control" value="<?php echo $mobilenumber; ?>">
                <span class="help-block"><?php echo $mobilenumber_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="add" class="btn btn-primary" value="Add"><br><br>
            </div>
            
            
            
        </form>
    </div>

  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<!----------------------------------------------------------------------------------------------------------->

<!----------------------------------------Update User-------------------------------------------------------->
<script type="text/javascript" src="script/getData.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<div id="id02" class="modal">
    <div class="modal-content animate">
       <form >
    <div>
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Update User">&times;</span>
    </div>
  </form>
      <h2>Update a User</h2>
        <form method="post">
         <input type="text" id="search-box" class="form-control" placeholder="Username Name" />
<div id="suggesstion-box"></div>
        </form>
      <br>
      <button name="search" type="submit" class="btn btn-primary search" onclick="myFunction()">Search</button>
      <br>

      <br>
      <div class="updatedetails">
      <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div id="myDIV" >
    <div >
            <div >
                <label>Username</label>
                <input  type="text" name="username" class="form-control" id="username"><br>
                
            </div>   
            
            <div >
                <label>First name</label>
                <input type="text" name="firstname" class="form-control" id="firstname"><br>
                
            </div>  
            
            <div >
                <label>Last name</label>
                <input type="text" name="lastname" class="form-control" id="lastname"><br>
                
            </div> 
            
            <div>
                <label>Email ID</label>
                <input type="text" name="emailid" class="form-control" id="emailid"><br>
                
            </div> 
            
            <div>
                <label>Mobile Number</label>
                <input type="text" name="mobilenumber" class="form-control" id="mobilenumber"><br>
               
            </div> 
            
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control" id="password"><br>
                
            </div>
            <div >
                <input type="submit" name="update" class="btn btn-primary" value="Update">
                <!--<input type="submit" name="search" class="btn btn-primary" value="Search">-->
            </div>
    </div>

  
      </div></form>
      </div>
    </div>

  
</div>
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "getusername.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});

function selectUsername(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>

<!--<script>
function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>-->

<script>
// Get the modal
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id04');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<!------------------------------------------------------------------------------------------------------------->

<!--------------------------------------------------Delete User------------------------------------------------>


<div id="id03" class="modal">
    <div class="modal-content animate">
       <form action="/action_page.php">
    <div>
      <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Delete User">&times;</span>
    </div>
  </form>
      <h2>Delete a User</h2>
        
        
            
             <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
             <select class="form-control" name="username" id="users">
    <?php foreach($usersdelete as $user): ?>
        <option value="<?= $user['id']; ?>"><?= $user['username']; ?></option>
    <?php endforeach; ?>
        
        
               
</select>
            </form>
            
            <br><br>
           
           
            <input type="submit" name="delete" id="delete" class="btn btn-primary" onclick="return confirm('Are you sure want to delete this user data?')" value="Delete">
        </form>
    </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('id03');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<!------------------------------------------------------------------------------------------------------------->
    <script>
        setTimeout( function ( ) { 
            document.getElementById('msg').innerHTML = "";
        }, 5000 );
    </script>
    
    <div class="container" align="center">
      <table style="width:100%">

	<tr bgcolor='#CCCCCC'>
		<th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
		<th>Mobile Number</th>
		<!--<td>Update</td>-->
	</tr>
	<?php 	
	while($row = $sql->fetch(PDO::FETCH_ASSOC)) { 		
		echo "<tr>";
		echo "<td>".$row['username']."</td>";
                echo "<td>".$row['firstname']."</td>";
                echo "<td>".$row['lastname']."</td>";
		echo "<td>".$row['emailid']."</td>";
		echo "<td>".$row['mobilenumber']."</td>";	
		//echo "<td><a href=\"edit.php?id=$row[id]\">Edit</a> | <a href=\"delete.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
    </div>
    
    <footer style="padding: 50px 20px 20px">
        <p style="text-align: center;">Terms of use | Copyright: © 2018 nfaktor. All rights reserved.</p>
</footer>
        
</body>
</html>