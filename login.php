<?php
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>OS library management system</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  
  
</head>
<body>
<img style="float: left; margin: 0px 100px 100px 0px; height:750px; width: 60%;" src="ptc.jpg" width="100" />
<div class="formPosition">
  <div class="header">
  	<h2>OS Library approval System </br></br>Login</h2>
  </div>

  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>

  		<div style="overflow: hidden;">
    <p style="float: left;">Not yet a member?</p>
    <p style="float: Left;color: blue;"><a href="register.php">Sign up</p>
</div>
  </form>
</div>
</body>
</html>