<?php
  	
if (isset($_POST['take_approval'])) {
  //  header('location: approvalTakerResponse.php')
    $conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $sql = "SELECT OsLink FROM approvaltaker where ApprovalTakerName ='{$_SESSION['username']}'";
    $result = $conn->query($sql);
    $Oldlink='';
    if ($result->num_rows > 0) {
        
       
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
            //$at_id =$row['At_id'];
            $Oldlink = $row['OsLink'];
            // $link = $row['OsLink'];
            //   $ApproverEmailId  = $row['ApproverEmailIds'];
        }
        if(strcmp($link,$Oldlink)==0){
            header('location: alreadyApplied.php');
        }
    } else {
        
        echo "0 results";
    }
    
  
   
    $at_id = '';
    $date = '';
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

    $str_arr = preg_split("/\,/", $address);
    $arrlength = count($str_arr);
    $x = 0;

    $subject = "Request for OS link approval";
    $body = "Request pending for Os link approval for the link : $link";

    
    if (mail($str_arr[0], $subject, $body)) {
        echo "Email successfully sent to $email...";    
    } else {
        echo "Email sending failed...";
    }
    
    
    
    while ($x < $arrlength) {
        echo "$address   ...";

        $sql = "SELECT At_id ,Date FROM approvaltaker where ApprovalTakerName = '{$_SESSION['username']}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                $at_id = $row['At_id'];
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

        $x ++;
    }
    
    ?>        
    </br>
		<!-- h2 style="font-family:sans-serif;padding-left:50px; text-align:center; color:red";> <?php // echo "Your OS library approval request is pending for approval Please wait for confirmation. It generally takes upto 24 Hours";?></h2-->
<?php echo '<script>alert("Your OS library approval request is pending for approval Please wait for confirmation. It generally takes upto 24 Hours.")</script>';?>
    
<?php }  ?>