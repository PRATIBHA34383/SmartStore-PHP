<?php
session_start(); $error="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $u=$_POST["username"]??""; $p=$_POST["password"]??"";
 if($u==="admin" && $p==="admin123"){$_SESSION["admin"]=$u;header("Location: dashboard.php");exit;}
 $error="Invalid username or password.";
} ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body><div class="container"><h1>Admin Login</h1><?php if($error):?><p class="error"><?=htmlspecialchars($error)?></p><?php endif;?>
<form method="post"><input name="username" placeholder="Username" required><input type="password" name="password" placeholder="Password" required><button>Login</button></form>
<p>Demo: admin / admin123</p></div></body></html>