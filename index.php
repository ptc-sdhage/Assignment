<?php 
  session_start(); 
  if (!isset($_SESSION['username'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: login.php');
  }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>OS library management system</h2>
</div>
<?php
// Create connection
 $conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT userType FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
if ($result && $result ->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      if($row['userType'] == "approval taker"){
         header('location: approvalTaker.php');          
      }else  if($row['userType'] == "approver") {
         header("location: approver.php"); 
      }
  }
} else {
  echo "0 results";
}
$conn->close();
?>

</div>
		
</body>
</html>