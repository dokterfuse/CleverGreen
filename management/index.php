<?php
// Include database connection
include '../db/db.php';

session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Als de gebruiker niet is ingelogd, redirect naar login.php
    header('Location: ../login/loginmanagement.php');
    exit();
}

// Set default values for filter and sort
$customerID = '';
$sort = 'date_desc';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = isset($_POST['filterInput']) ? trim($_POST['filterInput']) : '';
    $sort = isset($_POST['sortDropdown']) ? $_POST['sortDropdown'] : 'date_desc';
}

// Prepare the SQL query based on the filter and sort
$orderBy = ($sort === 'date_asc') ? 'ASC' : 'DESC';
$sql = "SELECT TransactionID, Status, TotalAmount, Date 
        FROM Transactions 
        WHERE CustomerID LIKE ?
        ORDER BY Date $orderBy";

$stmt = $conn->prepare($sql);
$likeCustomerID = "%$customerID%"; // Use LIKE for partial matches
$stmt->bind_param("s", $likeCustomerID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../header.php';?>
    <!-- Filter and Sort Form -->
    <form method="POST" action="index.php" id="filterBar">
        <input type="text" name="filterInput" placeholder="Filter by customer..." value="<?php echo htmlspecialchars($customerID); ?>">
        <select name="sortDropdown">
            <option value="date_desc" <?php if ($sort === 'date_desc') echo 'selected'; ?>>Newest First</option>
            <option value="date_asc" <?php if ($sort === 'date_asc') echo 'selected'; ?>>Oldest First</option>
        </select>
        <button type="submit">Apply</button>
    </form>

    <!-- Data Table -->
    <div id="dataTable">
        <?php if ($result->num_rows > 0): ?>
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
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['TransactionID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Status']); ?></td>
                            <td><?php echo htmlspecialchars($row['TotalAmount']); ?></td>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No transactions found.</p>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
