<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approval taker</title>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">


<body>
	<form method="post" >
<?php include('errors.php'); ?>
 <div class="library">
			<div class="input-group">
				<label>OS library link</label> <input type="text" name="link"
					value="<?php echo $link; ?>" />
			</div>
		</div>
		<div class="input-group">
			<div class="address">
				<label for="address">Email Ids of the approvers</label> <input
					type="text" name="address" id="address"
					value="<?php echo $address; ?>">
			</div>
		</div>

		<!-- button id="add-address" class= "btn">Add Email Id of approver</button>
    <br />
   
    <button id="add-address" class= "btn">Add OS library link</button-->
		<div class="input-group">
			<button type="submit" class="btn" name="take_approval">Take the
				approval</button>
		</div>
  	<?php

if (isset($_POST['take_approval'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $at_id='';
   $date='';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query = "INSERT INTO approvaltaker (ApprovalTakerName, OsLink, ApproverEmailIds, Date) VALUES ('{$_SESSION['username']}', '$link','$address', CURRENT_TIMESTAMP)";
    
    if ($conn->query($query) === TRUE) {
        echo "New record created successfully for approvaltaker";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
    mysqli_query($conn, $query);
    
    
    $str_arr = preg_split ("/\,/", $address);
    $arrlength = count($str_arr);
    $x = 0;
    
    while($x < $arrlength) {
        echo "$address   ...";
       // if (mail($str_arr[$x], $subject, $body, $headers)) {
            //echo "Email successfully sent to $str_arr[$x]...";
            //echo "</br>";
            
        $sql = "SELECT At_id ,Date FROM approvaltaker where ApprovalTakerName = '{$_SESSION['username']}'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $at_id =$row['At_id'];
                $date = $row['Date'];
            }
        } else {
            echo "0 results";
        }
        
        
            $query = "INSERT INTO approver (ApproverEmail, Response, Date, At_id) VALUES ('$str_arr[$x]', NULL,'$date','$at_id')";
            
            if ($conn->query($query) === TRUE) {
                echo "<br>" . " New record created successfully  for approver";
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
            
            mysqli_query($conn, $query);
            
       // } else {
         //   echo "Email sending failed...";
       // }
        $x++;
    }
    
    
    
    
    ?>        
    </br>
		<!-- h2 style="font-family:sans-serif;padding-left:50px; text-align:center; color:red";> <?php // echo "Your OS library approval request is pending for approval Please wait for confirmation. It generally takes upto 24 Hours";?></h2-->
<?php echo '<script>alert("Your OS library approval request is pending for approval Please wait for confirmation. It generally takes upto 24 Hours.")</script>';?>
    
<?php }?>
</form>


</body>
</head>
</html>
