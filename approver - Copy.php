<?php 
session_start();
$errors = array();
include('errors.php');
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>
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

}
.btnlogout {
  padding: 10px;
  
  font-size: 15px;
  color: white;
  background: #FF0000;
  border: none;
  border-radius: 5px;
  position: fixed;
  top: 5px;
  left: 1400px;
/*position:relative; right:-1300px; top:50px;*/
}
.inner
{
    display: inline-block;
}
.input-group {
  margin: -10px 0px 10px 0px;
}
.input-group input {
  height: 30px;
  width: 93%;
  padding: 0px 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid gray;
}
.btn {
  padding: 10px;
  font-size: 15px;
  color: white;
  background: #2E8B57;
  border: none;
  border-radius: 5px;
  
  width: 200px;
}
</style>


</head>
<body>
<div class="input-group">
			<button type="button" class="btnlogout" name="logout" ><a href="logout.php">Logout</a></button>
		</div>
<div class="header">
  	<h2>Approval Notification </h2>
  </div>
</div>
	<form method="post">

<p id="link"></p>

<h3> <?php 

$at_id ='';
$email ='';
$OsLink ='';
$ApprovalTakerName ='';
$at_id_array = array();
$response_array= array();
$name_array = array();
$date_array= array();
$link_array = array();
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
$sql = "SELECT At_id, Response FROM approver where ApproverEmail ='$email'";
$result = $conn->query($sql);

if ($result && $result ->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_array()) {
       // echo $row['At_id'];
        $at_id = $row['At_id'];
        $response = $row['Response'];
        array_push($at_id_array, $at_id);
        array_push($response_array, $response);
    }
    $response_index=0;
    $count=1;?>
    <h2 style= color:Black;>The following OS links needs to be approved.</br></h2></br>
    <?php foreach ($at_id_array as $at_id_value) {
      
        $sql = "SELECT OsLink, ApprovalTakerName,Date FROM approvaltaker where At_id =$at_id_value ";
        $result = $conn->query($sql);
        
        if ($result && $result ->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_array()) {
                $OsLink = $row['OsLink'];
                $ApprovalTakerName = $row['ApprovalTakerName'];
                $Date = $row['Date'];
            }
        } else {
            echo "0 results";
        }

        if(empty($response_array[$response_index])){
            array_push($name_array, $ApprovalTakerName);
            array_push($date_array, $Date);
            array_push($link_array, $OsLink);
            ?><h4 style= color:black;><?php  echo $count . ")"?> &nbsp; Requestor Name:  <?php echo $ApprovalTakerName?></br>&nbsp; &nbsp; &nbsp;&nbsp;Request time:  <?php echo $Date?></br><div class="div1"> &nbsp;&nbsp;&nbsp;&nbsp;<h4 style= color:green;> Approve or reject below link  </h4><?php
    echo "<h4 style= color:blue;><a href= $OsLink > $OsLink </a></div>";
    ?>
 <div class="inner">
 <div class="input-group">
    <button id="approve" class="btn"   name="approve"><a href="accept.php">Approve</a></button>
    </div>
    </div>
     <div class="inner">
    <div class="input-group">
    <button id="Reject" class="reject" name="reject"><a href="reject.php">Reject</a></button>
    </div>
    </div>
    
   <?php  $count=$count+1;    
    }
    else {
        ?><h4 style= color:black;><?php echo $count . ")"?>&nbsp; Requestor Name:  <?php echo $ApprovalTakerName?></br>&nbsp; &nbsp;&nbsp; Request time:  <?php echo $Date?></br> &nbsp;&nbsp;&nbsp;&nbsp;<h4 style= color:green;> You have already responded to below link  </h4><?php echo "<h4 style= color:blue;>  <a href= $OsLink >$OsLink</a>"?> </span></h4></div></br>
  <?php 
$count=$count+1;    
    }
  $response_index=$response_index+1;
  
    
}
    
  
}else {
    
    ?><h2 style= color:green;>No pending requests</h2><?php 
}
?></h3>
  
</form>
</body>
</html>
    
} 



   