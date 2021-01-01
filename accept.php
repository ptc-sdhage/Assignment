<?php 
include('approver.php');
if (isset($_POST['approve'])) {
    //$accept = 'Accept';
    echo "Os approval is confirmed";
    $subject = "Simple Email Test via PHP";
    $body = "Hi, This is test email send by PHP Script";
//  $to = "sdhagetestmail58@gmail.com";
    
  //  while($x < $arrlength) {
   //     echo "   ..$str_arr[$x].";

    if (mail($email, $subject, $body)) {
           // echo "Email successfully sent to $email...";
            echo "</br>";
            $sql = "UPDATE approver SET Response='Accepted' where ApproverEmail ='$email'";
            
            if ($conn->query($sql) === TRUE) {
                echo "UPDATE successful";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            mysqli_query($conn, $sql);
            
        } else {
            echo "Email sending failed...";
        }
       
   // }
}
  
?>