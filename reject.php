<?php
include('server.php');

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

echo "Os approval is Rejected";
include('approverHelper.php');

$email='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
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





//if (isset($_POST['approve'])) {

echo "</br>";
$sql = "UPDATE approver SET Response='Rejected' where ApproverEmail ='$email'";

if ($conn->query($sql) === TRUE) {
    echo "UPDATE successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_query($conn, $sql);
$at_id ="";
$ApproverEmailIds="";
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
    
    
    $sql1 = "SELECT ApproverEmailIds FROM approvaltaker where At_id ='$at_id'";
    $result1 = $conn->query($sql1);
    
    if ($result1->num_rows > 0) {
        // output data of each row
        while($row = $result1->fetch_assoc()) {
            
            //$at_id =$row['At_id'];
            $ApproverEmailIds = $row['ApproverEmailIds'];
            // $link = $row['OsLink'];
            //   $ApproverEmailIds = $row['ApproverEmailIds'];
        }
        
        print $ApproverEmailIds;
    } else {
        echo "0 results";
    }
    
} else {
    echo "0 results";
}




//}

?>