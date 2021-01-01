<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$link    = "";
$address = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'assignmentdb');

// REGISTER USER
if (isset($_POST['reg_user'])) {
   
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $userType = mysqli_real_escape_string($db, $_POST['userType']);
  
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }
  
  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
 
  	$query = "INSERT INTO users (username, email, password, userType) 
  			  VALUES('$username', '$email', '$password', '$userType')";
  	mysqli_query($db, $query);
  
  	
  	
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
  
  
}
// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}



//ad approval takers entries into db
/*if (isset($_POST['take_approval'])) {
    // receive all input values from the form
    $link = mysqli_real_escape_string($db, $_POST['link']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    if (empty($link)) { array_push($errors, "OS link is required"); }
    if (empty($address)) { array_push($errors, "One or more Email Ids of appprovers are required"); }
    if (count($errors) == 0) {
     /*   $str_arr = preg_split ("/\,/", $address);
   
     

       
        $subject = "Simple Email Test via PHP";
        $body = "Hi, This is test email send by PHP Script";
        $headers = "From: sdhagetestmail58@gmail.com";
        
     
        $arrlength = count($str_arr);
        $x = 0;
        
        while($x < $arrlength) {
     
           
            if (mail($str_arr[$x], $subject, $body, $headers)) {
                echo "Email successfully sent to $str_arr[$x]...";
                echo "</br>";
            } else {
                echo "Email sending failed...";
            }
            $x++;
        }*/
      /*  $query = "INSERT INTO approvaltaker (ApprovalTakerName, OsLink, ApproverEmailIds,Date) VALUES ('{$_SESSION['username']}','$link', '$address',CURRENT_TIMESTAMP)";
        mysqli_query($db, $query);
$_SESSION['success'] = "approval takers inputs are added";
    }
   
    
}
*/

?>