<?php
include('approver.php');
if (isset($_POST['reject'])) {
//$accept = 'Accept';
echo "Os approval is Rejected";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script";


//  while($x < $arrlength) {
//     echo "   ..$str_arr[$x].";
if (mail($email, $subject, $body)) {
//echo "Email successfully sent to $email...";
echo "</br>";
$sql = "UPDATE approver SET Response='Rejected' where ApproverEmail ='$email'";

if ($conn->query($sql) === TRUE) {
    echo "UPDATE successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_query($conn, $sql);

  } else {
     echo "Email sending failed...";
 }


}
else {
    echo "reject";
}
?>