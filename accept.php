<?php
session_start();
if (! isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

?>
<html>
<head>
<title>Acceptance</title>

<link rel="stylesheet" type="text/css" href="style.css">

</head>


 <?php
 if (isset($_POST['back'])) {
     header('location: approvalTaker.php');
 }
$oslink = $_GET['oslink'];
$approvaltakername = $_GET['approvaltakername'];
echo $oslink;
echo $approvaltakername;
$email = '';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
$link = '';
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $email = $row['email'];
    }
} else {
    echo "0 results";
}

$ApproverEmailIds = "";
$date = '';
$result = $conn->query($sql);
$sql1 = "SELECT At_id,Date FROM approvaltaker where OsLink='$oslink' AND ApprovalTakerName='$approvaltakername'";
$result1 = $conn->query($sql1);
if ($result1 && $result1->num_rows > 0) {
    // output data of each row
    while ($row = $result1->fetch_assoc()) {

        $at_id_1 = $row['At_id'];
        $date = $row['Date'];

    }
    $response = "Your request for open-source library \"$oslink\" is approved";
  //  echo "</br>";
   // echo "</br></br>";
    $sql = "UPDATE approver SET Response='$response' where ApproverEmail ='$email' AND  At_id ='$at_id_1'";
    
    if ($conn->query($sql) === TRUE) {
      ?>  // echo "UPDATE successful";
        <body>
        <div class="header">
        <h2>Approval Confirmation</h2>
        </div>
        <form method="post">
        
        
        <h3 style="color: green;">
        <span class="blink"> Os link is approved </span>
        </h3>
       
	</br>
	</br>
	</br>
	
			<button type="submit" class="btn" name="back";>BACK</button>
		
	
    <?php } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    mysqli_query($conn, $sql);
    $sql1 = "SELECT ApproverEmail FROM approver where At_id=$at_id_1 AND Response is NULL";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
       
        // output data of each row
        while ($row = $result1->fetch_assoc()) {

            $ApproverEmailIds = $row['ApproverEmail'];
            
            break;
           
        }
        $systemLink="http://localhost/registration/login.php";
        $subject = "Request for OS link approval";
        $body = "Request pending for Os link approval for the link : $oslink \nRequestor name: $approvaltakername \nRequest time: $date \nLogin to OS link approval system for more details and to approve or reject the request: $systemLink \n\n Thanks,\nAdmin(OS library management system)";
        if (mail($ApproverEmailIds, $subject, $body)) {
         //   echo "Email successfully sent to $ApproverEmailIds...";
        } else {
            echo "Email sending failed...";
        }
      
    }
    else {
        $sql = "SELECT email FROM users where username = '$approvaltakername'";
        $result = $conn->query($sql);
        $link = '';
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $email = $row['email'];
            }
        } else {
            echo "0 results";
        }
        $systemLink="http://localhost/registration/login.php";
        $subject = "Approval Notification";
        $body = "You request is approved for the link : $oslink.\n You can login to OS link approval System : $systemLink \n\n\n Thanks,\nAdmin(OS link approval system)";
        if (mail($email, $subject, $body)) {
               echo "Email successfully sent to $email...";
        } else {
            echo "Email sending failed...";
        }
        
    }
}
else {
    echo "0 results";
}

?></form>
</body>
</html>