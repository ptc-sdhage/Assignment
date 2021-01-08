<?php
session_start();
$errors = array();
include ('errors.php');
if (! isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approver</title>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="style.css">

<style>
.reject {
	padding: 10px;
	font-size: 15px;
	color: white;
	background: #FF0000;
	border: none;
	border-radius: 5px;
	display: inline-block;
	width: 200px;
}

.div1 {
	width: 80%;
	height: 100px;
}

.btnlogout {
	padding: 10px;
	width: 200px;
	font-size: 15px;
	color: white;
	background: #FF0000;
	border: none;
	border-radius: 5px;
	position: fixed;
	top: 5px;
	left: 1350px;
	/*position:relative; right:-1300px; top:50px;*/
}

.inner {
	margin-right: -5px;
	display: inline-block;
}

.input-group {
	margin: -10px -10px 10px 0px;
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
		<button type="button" class="btnlogout" name="logout">
			<a href="logout.php">Logout</a>
		</button>
	</div>
	<div class="header">
		<h2>Approval Notification</h2>
	</div>
	</div>


<?php

$at_id = '';
$email = '';
$OsLink = '';
$ApprovalTakerName = '';
$at_id_array = array();
$response_array = array();

$conn = mysqli_connect('localhost', 'root', '', 'assignmentdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email FROM users where username = '{$_SESSION['username']}'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        $email = $row["email"];
    }
} else {
    echo "0 results";
}

$sql = "SELECT At_id, Response FROM approver where ApproverEmail='$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {  //check if approver has any requests

    ?>    
    <h3>
		<table id="table" class="display" style="width: 100%">   <!--  diplay all the requests in table format-->
			<thead>
				<tr>
					<th>Request No</th>
					<th>Requestor Name</th>
					<th>Request time</th>
					<th>Open source library link</th>
					<th>Your response</th>

				</tr>
			</thead>
			<tbody><?php

   
    while ($row = $result->fetch_array()) {        //take approvaltaker id and respnse to put in the table
        $at_id = $row['At_id'];
        $response = $row['Response'];
        array_push($at_id_array, $at_id);
        array_push($response_array, $response);
    }
    $response_index = 0;
    $count = 1;
    ?>
    <h2 style="color: Black;">
					</br>The following OS links needs to be approved.</br>
				</h2>
				</br>
    <?php

foreach ($at_id_array as $at_id_value) {                 //for rach approval taker request assigned to same approver

        $sql = "SELECT OsLink, ApprovalTakerName,Date FROM approvaltaker where At_id =$at_id_value ";         //take oslink and name , date of approvaltaker
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                $OsLink = $row['OsLink'];
                $ApprovalTakerName = $row['ApprovalTakerName'];
                $Date = $row['Date'];
            }
        } else {
            echo "0 results";
        }

        if (empty($response_array[$response_index])) {                //if response has not given, that is reuest is pending for approval

            echo "<tr><td>" . $count . "</td>
                <td>" . $ApprovalTakerName . "</td>
                <td>" . $Date . "</td>
               <td><h4 style= color:blue;><a href= $OsLink > " . $OsLink . "</td>
<td><div class=\"inner\">
 <div class=\"input-group\"><button id=\"approve\" class=\"btn\" name=\"approve\"><a href=\"accept.php?oslink=$OsLink&approvaltakername=$ApprovalTakerName\">Approve</a></button></div>
    </div></td>
           <td> <div class=\"inner\">
 <div class=\"input-group\"><button style= \"position: relative; left: 0px;\" id=\"Reject\" class=\"reject\" name=\"reject\"><a href=\"reject.php?oslink=$OsLink&approvaltakername=$ApprovalTakerName\">Reject</a></button></div>
    </div></td></tr>";

            $count = $count + 1;
        } else {              //if response has  given already
            
            echo "<tr>      <td>" . $count . "</td>
                <td>" . $ApprovalTakerName . "</td>
                <td>" . $Date . "</td>
                <td><h4 style= color:blue;><a href= $OsLink > " . $OsLink . "</td>
<td> You have already responded for this link </td></tr>";
            $count = $count + 1;
        }
        $response_index = $response_index + 1;
    }
    echo "</thread>";
    echo "</table>";
} else {

    ?><div class="blink">
					<h1 style="color: green; margin-left: 620px;">
						</br>
						</br>No pending requests
					</h1>
				</div><?php
}
?></h3>

				</form>
				<script>
$(document).ready(function() {
    $('#table').DataTable();
} );

</script>

</body>
</html>





