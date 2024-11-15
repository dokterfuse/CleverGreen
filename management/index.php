<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Interface</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Management Dashboard</h1>
    <div id="managementData"></div>

    <script>
        // Fetch data from the API and display it
        fetch('../api/api.php')
            .then(response => response.json())
            .then(data => {
                const managementData = document.getElementById('managementData');
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = JSON.stringify(item);
                    managementData.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
