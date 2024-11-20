<?php
// Include database connection
include '../db/db.php';

// Set response type to JSON
header('Content-Type: application/json');

// Handle GET requests (Transaction details by CustomerID)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $customerID = isset($_GET['CustomerID']) ? $_GET['CustomerID'] : null;

    if ($customerID) {
        // Prepare SQL query to fetch transaction details
        $sql = "SELECT TransactionID, Status, TotalAmount, Date FROM Transactions WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any transactions were found
        if ($result->num_rows > 0) {
            $transactions = [];
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
            }
            echo json_encode($transactions);
        } else {
            // No transactions found
            echo json_encode(["message" => "No transactions found for this CustomerID."]);
        }
    } else {
        echo json_encode(["message" => "Please provide a valid CustomerID."]);
    }
    
    exit; 
}

// Close the database connection
$conn->close();
?>
