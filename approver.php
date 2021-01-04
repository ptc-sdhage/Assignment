
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approver</title>
<link rel="stylesheet" type="text/css" href="style.css">
<style>



.div1 {
  width: 80%;
  height: 100px;
  border: 1px solid blue;
}



</style>


</head>
<body>

    <div class="header">
  	<h2>OS Library approval System </h2>
  </div>
   <form method="post"> 
	
<?php
$errors = array();
include('errors.php'); include('approverHelper.php');?>
<p id="link"></p>
<div class="input-group">
<h3> <?php 
$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
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

    while ($row = $result->fetch_assoc()) {
        
        $response = $row['Response'];
    }
    
    if(empty($response)){
    ?>
    

    </h3><h3 <h2 style= color:Black;>The following OS link needs to be approved for the user <u><?php echo $ApprovalTakerName?></u> :</h3></br><div class="div1"></br></br><?php 
    echo "<h3 style= color:blue;> $OsLink </div>";
    ?>
    </br>
    <button id="approve" class="btn"   name="approve"><a href="accept.php">Approve</a></button>
    
    </div>
    <div class="input-group">
    <button id="Reject" class="reject" name="reject"><a href="reject.php">Reject</a></button>
    
    </div>
    
   <?php  
    }
    else {?>
        <h2 style= color:green;><span class="blink">You have already responded to the link  </h2><?php echo "<h3 style= color:blue;>  </br>$OsLink"?> </span></h3></div></br>
  

  <?php   }
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