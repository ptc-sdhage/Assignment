<?php include('server.php');

if(isset($_GET['diff'])){
    

if($_GET['diff'])
{
    echo "<script>alert('Already applied to same OS link with different approver Email Ids');</script>"; 
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approval taker</title>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<head>
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
  	<h2>OS Library approval System </h2>
  </div>
	<form method="post">

<?php include('errors.php'); ?>
 <div class="library">
 
 
			<div class="input-group">
				<label>OS library link</label> <input type="text" name="link" id="link"
					value="<?php echo $link; ?>" />
			</div>
		</div>
		<div class="input-group">
			<div class="address">
				<label for="address">Email Ids of the approvers<h5 style="color:#483D8B;">(Please provide comma(,)separated list of Emails)</h5></label> <input
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
		<div class="input-group">
			<button type="submit" class="btnlogout" name="logout" ><a href="login.php?logout='1'">Logout</a></button>
		</div>
</form>

</body>
</head>
</html>
