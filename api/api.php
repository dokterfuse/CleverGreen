<?php
// api/api.php
include '../db/db.php';

header('Content-Type: application/json');

// Example route for getting data
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM your_table";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
    exit;
}

// Example route for posting data (replace with actual logic)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST requests here
    echo json_encode(["message" => "POST request handled"]);
    exit;
}

$conn->close();
?>
