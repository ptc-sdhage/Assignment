<?php



// initializing variables
$username = "";
$email = "";
$link = "";
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
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
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
        $password = md5($password_1); // encrypt the password before saving in the database

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
            echo "loged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
if (isset($_POST['take_approval'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    echo $link;
    $query = "SELECT * FROM approvaltaker WHERE OsLink='$link'";
    $result = $conn->query($query);
   
    if ($result && $result->num_rows > 0) {
        header("Location:approvalTakerResponseForAlready.php? takerResponse=$link");
    } else {

        $query = "INSERT INTO approvaltaker (ApprovalTakerName, OsLink, ApproverEmailIds, Date) VALUES ('{$_SESSION['username']}', '$link', '$address', CURRENT_TIMESTAMP)";
        mysqli_query($db, $query);

        $at_id = '';
        $date = '';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $str_arr = preg_split("/\,/", $address);
        $arrlength = count($str_arr);
        $x = 0;

        $subject = "Request for OS link approval";
        $body = "Request pending for Os link approval for the link : $link";

        if (mail($str_arr[0], $subject, $body)) {
            // echo "Email successfully sent to $email...";
        } else {
            echo "Email sending failed...";
        }

        while ($x < $arrlength) {

            $sql = "SELECT At_id ,Date FROM approvaltaker where ApprovalTakerName = '{$_SESSION['username']}'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {

                    $at_id = $row['At_id'];
                    $date = $row['Date'];
                }
            } else {
                echo "0 results";
            }

                $query = "INSERT INTO approver (ApproverEmail, Response, Date, At_id) VALUES ('$str_arr[$x]', NULL,'$date','$at_id')";
                mysqli_query($conn, $query);
            $x ++;
        }

        ?>


<?php

header("Location:approvalTakerResponse.php");
    }
}

?>