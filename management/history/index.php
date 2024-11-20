<?php
// Include database connection
include '../../db/db.php'; 

// Initialize the result variable
$transactionDetails = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the CustomerID from the POST request
    $customerID = isset($_POST['CustomerID']) ? $_POST['CustomerID'] : null;

    if ($customerID) {
        // Prepare and execute the SQL query to fetch transaction details for the given CustomerID
        $sql = "SELECT TransactionID, Status, TotalAmount, Date FROM Transactions WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if we found any transactions
        if ($result->num_rows > 0) {
            $transactionDetails = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array
        } else {
            $transactionDetails = 'No transactions found for this CustomerID.';
        }
    } else {
        $transactionDetails = 'Please provide a valid CustomerID.';
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<body>

<div class="form-container">
    <h1>Transaction History</h1>
    <form method="POST" action="">
        <label for="CustomerID">Customer ID:</label>
        <input type="number" id="CustomerID" name="CustomerID" required>
        <button type="submit">Search</button>
    </form>
</div>

<div class="result-container">
    <?php if ($transactionDetails === null) { ?>
        <!-- No results yet -->
    <?php } elseif (is_array($transactionDetails)) { ?>
        <!-- Display transaction details in a table -->
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactionDetails as $transaction) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['TransactionID']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Status']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['TotalAmount']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <!-- Display error message -->
        <p class="error-message"><?php echo $transactionDetails; ?></p>
    <?php } ?>
</div>

</body>
</html>
