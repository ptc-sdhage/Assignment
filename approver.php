<?php 
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
} else {
    echo "0 results";
}


$sql = "SELECT OsLink,ApprovalTakerName FROM approvaltaker where At_id =$at_id ";
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




?>



<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approver</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
<h3>The following OS link needs to be approved</h3>
<br>

</div>
	<form method="post">
<p id="link"></p>
<div class="input-group">
<h3> <?php echo $OsLink ." for the user " .$ApprovalTakerName;?></h3>
<button id="approve" class="btn"   name="approve"><a href="accept.php">Approve</a></button>

</div>
<div class="input-group">
<button id="Reject" class="btn" name="reject"><a href="reject.php">Reject</a></button>

</div>




</form>
</body>
</html>