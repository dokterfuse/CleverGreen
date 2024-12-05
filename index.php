<?php

// Zet de paginatitel
$pageTitle = "Welcome!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Link to External CSS File -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $pageTitle; ?></h1>
    </header>
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
    </nav>

    <main>
        <h2>Welcome to the homepage of Clever Green
        
        <h3>Latest News</h3>
        <ul>
            <li>New features added to the website.</li>
            <li>Our team is working on improving the user experience.</li>
        </ul>

        <p>If you'd like to know more about our services or get in touch, feel free to browse the rest of the site.</p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website. All Rights Reserved.</p>
    </footer>
</body>
</html>
