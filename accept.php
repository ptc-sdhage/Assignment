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
echo "Os approval is confirmed";
include('approverHelper.php');

$email='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
$link='';

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
               
                
                $sql1 = "SELECT ApproverEmailIds,OsLink FROM approvaltaker where At_id ='$at_id'";
                $result1 = $conn->query($sql1);
                
                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row = $result1->fetch_assoc()) {
                        
                        //$at_id =$row['At_id'];
                        $ApproverEmailIds = $row['ApproverEmailIds'];
                        $link = $row['OsLink'];
                        //   $ApproverEmailIds = $row['ApproverEmailIds'];
                    }
                   // echo $ApproverEmailIds;
                    $subject = "Request for OS link approval";
                    $body = "Request pending for Os link approval for the link : $link";
                    $str_arr = preg_split("/\,/", $ApproverEmailIds);
                    $arrlength = count($str_arr);
                    $x = 1;  // First Email id has already sent the email
                    echo $arrlength;
                    while ($x < $arrlength) {
                        if (mail($str_arr[$x], $subject, $body)) {
                            echo "Email successfully sent to $str_arr[$x]...";
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
            
            $response = "Your request for open-source library $link  is approved";
            echo "</br>";
            $sql = "UPDATE approver SET Response='$response' where ApproverEmail ='$email'";
            
            if ($conn->query($sql) === TRUE) {
                echo "UPDATE successful";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            mysqli_query($conn, $sql);
            
            
//}
  
?>