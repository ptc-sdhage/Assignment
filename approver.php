
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approver</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
.btnlogout {
  padding: 10px;
  
  font-size: 15px;
  color: white;
  background: #FF0000;
  border: none;
  border-radius: 5px;

}
.btn {
  padding: 10px;
  font-size: 15px;
  color: white;
  background: #00008B;
  border: none;
  border-radius: 5px;
   display:inline-block;
   margin-right:5px;
}

form, .content {
  margin: 80px auto;
  background: #FFF5EE;
  width: 80%;
}
.div1 {
  width: 80%;
  height: 100px;
  border: 1px solid blue;
}
</style>


</head>
<body>


</div>
	<form method="post">
	
<?php
$errors = array();
include('errors.php'); include('approverHelper.php');?>
<p id="link"></p>
<div class="input-group">
<h3> <?php 
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
//$username = $_GET['userName'];
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


$query = "SELECT * FROM approver WHERE ApproverEmail='$email'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {

    ?><h3 <h2 style= color:Black;>The following OS link needs to be approved</h3><div class="div1"></br><?php 
    echo "<h3 style= color:##1E90FF;> $OsLink </div></h3><h3 style= color:black;> for the user $ApprovalTakerName</h3>";
    ?>
    </br>
    <button id="approve" class="btn"   name="approve"><a href="accept.php">Approve</a></button>
    
    </div>
    <div class="input-group">
    <button id="Reject" class="btn" name="reject"><a href="reject.php">Reject</a></button>
    
    </div>
  <?php   
}else {
    ?><h2 style= color:green;>No pending requests</h2><?php 
}
?></h3>
   <div class="input-group">
			<button type="submit" class="btnlogout" name="logout" ><a href="login.php?logout='1'">Logout</a></button>
		</div>
</form>
</body>
</html>