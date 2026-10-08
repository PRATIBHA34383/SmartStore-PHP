<?php
session_start(); if(!isset($_SESSION["admin"])){header("Location: login.php");exit;}
?><!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body><div class="container"><h1>SmartStore Dashboard</h1><p>Welcome, <?=htmlspecialchars($_SESSION["admin"])?>!</p>
<div class="cards"><div>Products<br><strong>0</strong></div><div>Stock<br><strong>0</strong></div><div>Today's Sales<br><strong>₹0</strong></div></div><a href="logout.php">Logout</a></div></body></html>