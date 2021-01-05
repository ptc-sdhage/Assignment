
<?php 
//session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
$at_id ='';
$email ='';
$OsLink ='';
$ApprovalTakerName ='';
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);

if ($result && $result ->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $email = $row['email'];
    }
} else {
    echo "0 results";
}
$sql = "SELECT At_id FROM approver where ApproverEmail ='$email'";
$result = $conn->query($sql);

if ($result && $result ->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $at_id = $row['At_id'];
    }
    
    $sql = "SELECT OsLink, ApprovalTakerName FROM approvaltaker where At_id =$at_id ";
    $result = $conn->query($sql);
    
    if ($result && $result ->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $OsLink = $row['OsLink'];
            $ApprovalTakerName = $row['ApprovalTakerName'];
        }
    } else {
        echo "0 results";
    }
       
    
} 



?>
