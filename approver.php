

<?php include('approverHelper.php') ?>


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
</style>


</head>
<body>
<div class="header">
<h3>The following OS link needs to be approved</h3>
<br>

</div>
	<form method="post">
<p id="link"></p>
<div class="input-group">
<h3> <?php echo $OsLink ." for the user " .$ApprovalTakerName;?></h3>
<button id="approve" class="btn"   name="approve"><a href="accept.php">Approve</a></button>

</div>
<div class="input-group">
<button id="Reject" class="btn" name="reject"><a href="reject.php">Reject</a></button>

</div>

		<div class="input-group">
			<button type="submit" class="btnlogout" name="logout" ><a href="logout.php">Logout</a></button>
		</div>


</form>
</body>
</html>