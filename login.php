<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>OS library management system</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
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

</body>
</html>