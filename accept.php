<?php 
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

?>
<html>
<head>
<title>

Accepted
</title>

<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
 <div class="header">
  	<h2>OS Library approval System </h2>
  </div>
	<form method="post">


    <h3 style= color:green;><span class="blink"> Os link is approved </span></h3>
 <?php 
include('approverHelper.php');

$email='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
$link='';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $email = $row['email'];
    }
} else {
    echo "0 results";
}


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
                   // echo $ApproverEmailIds;
                    $subject = "Request for OS link approval";
                    $body = "Request pending for Os link approval for the link : $link";
                    $str_arr = preg_split("/\,/", $ApproverEmailIds);
                    $arrlength = count($str_arr);
                    $x = 1;  // First Email id has already sent the email
                    while ($x < $arrlength) {
                        if (mail($str_arr[$x], $subject, $body)) {
                           // echo "Email successfully sent to $str_arr[$x]...";
                        } else {
                           echo "Email sending failed...";
                        }
                        $x++;
                    }
                       
                } else {
                    echo "0 results";
                }
                
            } else {
                echo "0 results";
            }
            
            $response = "Your request for open-source library \"$link\" is approved";
            echo "</br>";
            $sql = "UPDATE approver SET Response='$response' where ApproverEmail ='$email'";
            
            if ($conn->query($sql) === TRUE) {
               // echo "UPDATE successful";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            mysqli_query($conn, $sql);
            
            
//}
      
?></form>
</body>
      </html>