<?php 
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
 $errors = array();?>
<html>
<head>
<title>

OS library approval system
</title>

<link rel="stylesheet" type="text/css" href="style.css">
<style>
form, .content {
  margin: 120px auto;
  background: #FFF5EE;
  width: 80%;
  
 border: 4px solid #B0C4DE;
  background: white;
}

</style>
</head>
</body>
<form method="post">
<?php include('errors.php'); ?>
<h3 style= color:green; align="center"> Your OS library approval request is pending for approval. Please wait for confirmation. </br></br>It generally takes upto 24 Hours. </h3>
	<div class="buttonposition">
	</br>
	<div class="input-group">
			<button type="submit" class="btn" name="back";>BACK</button>
		</div>
		</div>
</form>
</body>

</html>
</br>
</br>
</br>
</br>

<?php 










if (isset($_POST['back'])) {
       header('location: approvalTaker.php');
}
?>

