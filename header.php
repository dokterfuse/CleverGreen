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
        <a href="management/index.php">Management</a>
        <a href="#">Agents</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        
        <!-- Dropdown Menu for Dashboard -->
        <div class="dropdown">
            <div class="dropdown-content">
                <a href="management/history/index.php">History</a>
                <a href="management/history/index.php">Management</a>
            </div>
        </div>

        <!-- Logout Button -->
        <a href="?logout=true">Logout</a>
    </nav>
</header>
