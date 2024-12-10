<?php
session_start();
include '../db/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Controleer of de velden niet leeg zijn
    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM Customers WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $agent = $result->fetch_assoc();

            if ($password === $agent['password']) { 
                $_SESSION['agent_logged_in'] = true; 
                header('Location: ../agents/index.php'); 
                exit();
            } else {
                $error = "Wrong password.";
            }
            
        } else {
            $error = "User not found.";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen voor Agents</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="loginagents.php" id="filterBar"> 
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Log in</button>
    </form>
</body>
</html>
