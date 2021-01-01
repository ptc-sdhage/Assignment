<?php

//include('accept.php');
//include('reject.php');
session_start(); 
$at_id ='';
$email ='';
$OsLink ='';
$ApprovalTakerName ='';
//  $ApproverEmailIds ='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        //$at_id =$row['At_id'];
        $email = $row['email'];
        // $link = $row['OsLink'];
        //   $ApproverEmailIds = $row['ApproverEmailIds'];
    }
} else {
    echo "0 results";
}
$sql = "SELECT At_id FROM approver where ApproverEmail ='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        //$at_id =$row['At_id'];
        $at_id = $row['At_id'];
        // $link = $row['OsLink'];
        //   $ApproverEmailIds = $row['ApproverEmailIds'];
    }
    
    $sql = "SELECT OsLink, ApprovalTakerName FROM approvaltaker where At_id =$at_id ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
            //$at_id =$row['At_id'];
            $OsLink = $row['OsLink'];
            $ApprovalTakerName = $row['ApprovalTakerName'];
            // $link = $row['OsLink'];
            //   $ApproverEmailIds = $row['ApproverEmailIds'];
        }
    } else {
        echo "0 results";
    }
    
    
    
    
    
    
    
} else {
    header('location: request.php');
   
}




?>
