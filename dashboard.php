<?php
// Anzisha session ili tuweze kusoma taarifa za aliyeingia
session_start();

// Angalia kama mtumiaji hajalogin (kama hana session ya username), mrudishe kwenye login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ukurasa Mkuu (Dashboard)</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .dashboard-container { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; width: 100%; max-width: 450px; }
        h1 { color: #333; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 25px; }
        .logout-btn { display: inline-block; background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-size: 16px; transition: background 0.3s; }
        .logout-btn:hover { background-color: #c82333; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Karibu Sana!</h1>
    <p>Umefanikiwa kuingia kwenye mfumo ukitumia akaunti ya: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    
    <a href="logout.php" class="logout-btn">Toka Kwenye Mfumo (Logout)</a>
</div>

</body>
</html>
