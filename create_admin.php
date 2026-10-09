```php
<?php
session_start();

require_once __DIR__ . "/config/database.php";

// Allow this setup page only on the local computer.
$host = $_SERVER["HTTP_HOST"] ?? "";

if (!in_array($host, ["localhost", "127.0.0.1", "localhost:80", "127.0.0.1:80"], true)) {
    http_response_code(403);
    exit("Run this setup locally using XAMPP only.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = "admin";
    $password = $_POST["password"] ?? "";

    if (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
    } else {
        $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Admin already exists. Setup is not needed.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                "INSERT INTO admins (username, password) VALUES (?, ?)"
            );
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                $message = "Admin created. Delete create_admin.php after setup.";
            } else {
                $message = "Could not create admin. Please check the database.";
            }
            $stmt->close();
        }

        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create SmartStore Admin</title>
</head>
<body>
    <h1>Create SmartStore Admin</h1>
    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="password">Choose admin password (minimum 8 characters):</label>
        <input id="password" type="password" name="password" minlength="8" required>
        <button type="submit">Create Admin</button>
    </form>
</body>
</html>
```
