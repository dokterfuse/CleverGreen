<?php
session_start();
include '../db/db.php'; // Zorg ervoor dat je database-verbinding is opgenomen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Controleer of de velden niet leeg zijn
    if (!empty($email) && !empty($password)) {
        // Bereid SQL-query voor
        $sql = "SELECT * FROM Owners WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $email = $result->fetch_assoc();

            if ($password === $email['Password']) { 
                $_SESSION['logged_in'] = true;
                header('Location: ../management/index.php');
                exit();
            } else {
                $error = "Onjuist wachtwoord.";
            }
            
        } else {
            $error = "Gebruiker niet gevonden.";
        }
    } 

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../header.php';?>
    <h3>Inloggen</h3>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="loginmanagement.php"> 
        <label for="email">Gebruikersnaam:</label>
        <input type="text" name="email" id="email" required>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Inloggen</button>
    </form>
</body>
</html>
