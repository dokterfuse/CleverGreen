<?php
session_start();

// Handle Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>

<header>
    <nav>
        <a href="../index.php">Back</a>   
        <!-- Logout Button -->
        <a href="?logout=true">Logout</a>
    </nav>
</header>
