<?php 

include('server.php');
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');

    $takerResponse=$_GET['takerResponse'];

$sql1 = "SELECT At_id FROM approvaltaker where OsLink='$takerResponse'";
$result1 = $conn->query($sql1);
$at_id='';
if ($result1 && $result1->num_rows > 0) {
    
    // output data of each row
    while($row = $result1->fetch_assoc()) {
        
        $at_id = $row['At_id'];
       
    }
    
}
else
    print "no records";


$sql1 = "SELECT Response, ApproverEmail FROM approver where At_id=$at_id";
$result1 = $conn->query($sql1);

if ($result1 && $result1->num_rows > 0) {
    
    // output data of each row
    while($row = $result1->fetch_assoc()) {
        
        $response = $row['Response'];
        if (empty($response)) {
            echo '<script> cleartext(); </script>';
            echo  "Os link approval request is already sent to " .$row['ApproverEmail'] ."</br>";
        }
        else {
            echo $response. " by ".$row['ApproverEmail']."</br>";         }
        
        
    }
   
}
else
    print "no records";

?>