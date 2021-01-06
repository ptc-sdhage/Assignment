<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["ApprovalTakerName"]);
unset($_SESSION["OsLink"]);

header("Location:login.php");
?>