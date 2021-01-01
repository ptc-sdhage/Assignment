<?php include('server.php');
include('approvaltakerHelper.php');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approval taker</title>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">


<body>
	<form method="post">
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
  	
</form>


</body>
</head>
</html>
