<?php
// Include database connection
include '../db/db.php';

session_start();

// Controleer of de gebruiker is ingelogd via loginagents.php
if (!isset($_SESSION['agent_logged_in']) || $_SESSION['agent_logged_in'] !== true) {
    // Als de gebruiker niet is ingelogd, redirect naar loginagents.php
    header('Location: ../login/loginagents.php');
    exit();
}

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Handle form submission for placing an order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input values from the form
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Input validation
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        $errorMessage = 'Amount must be a positive number.';
    } elseif (empty($description)) {
        $errorMessage = 'Description is required.';
    } else {
        // Insert the order into the database (no customer ID needed)
        $sql = "INSERT INTO Orders (Amount, Description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $amount, $description); // "d" for double, "s" for string

        if ($stmt->execute()) {
            $successMessage = 'Your order has been successfully placed.';
        } else {
            $errorMessage = 'There was an error placing your order. Please try again.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

    <!-- Display error or success message -->
    <?php if ($errorMessage): ?>
        <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>
    <?php if ($successMessage): ?>
        <div class="success"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>

    <!-- Order Form -->
    <form method="POST" action="index.php" id="filterBar">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" placeholder="Enter amount" required value="<?php echo isset($amount) ? htmlspecialchars($amount) : ''; ?>">

        <label for="description">Description:</label>
        <textarea name="description" id="description" placeholder="Enter description" required><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>

        <button type="submit">Place Order</button>
    </form>

<?php $conn->close(); ?>
</body>
</html>
