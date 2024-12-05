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

            // Verifieer het wachtwoord
            if (password_verify($password, $email['Password'])) {
                // Start een sessie en sla gebruikersinfo op
                $_SESSION['logged_in'] = true;

                // Stuur gebruiker naar de management-pagina
                header('Location: management/index.php');
                exit();
            } else {
                $error = "Onjuist wachtwoord.";
            }
        } else {
            $error = "Gebruiker niet gevonden.";
        }
    } else {
        $error = "Vul alle velden in.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h3>Inloggen</h3>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php"> 
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Inloggen</button>
    </form>
</body>
</html>
