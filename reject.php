<html>
<head>
<title>

Accepted
</title>

<link rel="stylesheet" type="text/css" href="style.css">
<style>


</style>
</head>
<body>
  <div class="header">
  	<h2>OS Library approval System </h2>
  </div>
	<form method="post">

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
?><h2 style= color:green;><span class="blink"> Os approval is Rejected </span></h2>
<?php 
include('approverHelper.php');

$email='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
if ($result && $result ->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        $email = $row['email'];
    }
} else {
    echo "0 results";
}

echo "</br>";

$at_id ="";
$ApproverEmailIds="";
$sql = "SELECT At_id FROM approver where ApproverEmail ='$email'";
$result = $conn->query($sql);

if ($result && $result ->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $at_id = $row['At_id'];
    }
    
    $sql1 = "SELECT ApproverEmailIds,OsLink FROM approvaltaker where At_id ='$at_id'";
    $result1 = $conn->query($sql1);
    
    if ($result1 && $result1 ->num_rows > 0) {
        // output data of each row
        while($row = $result1->fetch_assoc()) {
            $ApproverEmailIds = $row['ApproverEmailIds'];
             $link = $row['OsLink'];
        }
        
        
    } else {
        echo "0 results";
    }
    
} else {
    echo "0 results";
}

$response = "Your request for open-source library \"$link\" is rejected";
$sql = "UPDATE approver SET Response='$response' where ApproverEmail ='$email'";

if ($conn->query($sql) === TRUE) {
    
    $sql = "DELETE FROM approver WHERE At_id ='$at_id' and Response IS NULL";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully with at_id = . $at_id";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    
    //echo "UPDATE successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_query($conn, $sql);


?></form>
</body>
      </html>