<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Interface</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Management Dashboard</h1>

    <div id="filterBar">
        <input type="text" id="filterInput" placeholder="Filter by customer...">
        <select id="sortDropdown">
            <option value="date_desc">Newest First</option>
            <option value="date_asc">Oldest First</option>
        </select>
    </div>
    
    <div id="dataTable"></div>

    <script>
        function fetchData() {
            const dataTable = document.getElementById('dataTable');
            dataTable.innerHTML = '<div>Loading...</div>'; // Show loading indicator

            const filter = document.getElementById('filterInput').value;
            const sort = document.getElementById('sortDropdown').value;

            fetch(`../api/api.php?filter=${filter}&sort=${sort}`)
                .then(response => response.json())
                .then(data => {
                    dataTable.innerHTML = ""; // Clear existing data
                    if (data.length === 0) {
                        dataTable.innerHTML = '<div>No transactions found.</div>';
                    } else {
                        data.forEach(item => {
                            const row = document.createElement('div');
                            row.textContent = `Transaction: ${item.id}, Date: ${item.created_at}`;
                            dataTable.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    dataTable.innerHTML = '<div style="color:red;">Failed to load data. Please try again later.</div>';
                });
        }

        // Attach event listeners
        document.getElementById('filterInput').addEventListener('input', fetchData);
        document.getElementById('sortDropdown').addEventListener('change', fetchData);

        // Fetch initial data on page load
        fetchData();
    </script>
</body>
</html>
