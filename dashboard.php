```php
<?php
session_start();

if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$adminName = htmlspecialchars(
    $_SESSION["admin"],
    ENT_QUOTES,
    "UTF-8"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartStore Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>SmartStore Dashboard</h1>

        <p>Welcome, <?= $adminName ?>!</p>

        <h2>Business Management System</h2>
        <p>Products, inventory, billing and reports will appear here.</p>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
```
