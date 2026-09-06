<?php
session_start();

// Taarifa za kuunganisha na Database (Badilisha password kama unayo kwenye MariaDB yako)
$host = "localhost";
$db_user = "root";
$db_pass = ""; 
$db_name = "mfumo_wangu";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Angalia kama muunganisho umekubali
if ($conn->connect_error) {
    die("Imeshindikana kuunganisha na Database: " . $conn->connect_error);
}

$error_message = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Tunatumia Prepared Statements kuzuia SQL Injection
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Hakiki kama password ni sahihi
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                
                // Mpeleke mtumiaji kwenye ukurasa wa dashboard au nyumbani
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Password si sahihi!";
            }
        } else {
            $error_message = "Username haipo!";
        }
        $stmt->close();
    } else {
        $error_message = "Tafadhali jaza sehemu zote!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingia kwenye Mfumo</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error { color: #d9534f; background: #f9eded; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; font-size: 14px; }
        .register-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .register-link a { color: #007bff; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Ingia Kwenye Mfumo</h2>
    
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" name="login">Ingia</button>
    </form>
    
    <div class="register-link">
        Una akaunti? La, bado? <a href="register.php">Jisajili hapa</a>
    </div>
</div>

</body>
</html>
