```php
<?php
session_start();

require_once __DIR__ . "/config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, username, password FROM admins WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($adminId, $adminUsername, $storedPassword);

    if ($stmt->fetch()) {
        $stmt->close();

        // Verify a securely hashed password.
        $validPassword = password_verify(
            $password,
            $storedPassword
        );

        // One-time migration for the existing demo account.
        if (
            !$validPassword &&
            password_get_info($storedPassword)["algo"] === null &&
            hash_equals($storedPassword, $password)
        ) {
            $newHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $update = $conn->prepare(
                "UPDATE admins SET password = ? WHERE id = ?"
            );
            $update->bind_param("si", $newHash, $adminId);
            $update->execute();
            $update->close();

            $validPassword = true;
        }

        if ($validPassword) {
            session_regenerate_id(true);
            $_SESSION["admin"] = $adminUsername;
            $_SESSION["admin_id"] = $adminId;

            header("Location: dashboard.php");
            exit;
        }
    } else {
        $stmt->close();
    }

    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartStore Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>SmartStore Login</h1>

        <?php if ($error !== ""): ?>
            <p class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <input
                type="text"
                name="username"
                placeholder="Username"
                autocomplete="username"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
```
