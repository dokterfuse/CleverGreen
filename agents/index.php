<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agents Interface</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Agent Dashboard</h1>
    <div id="agentData"></div>

    <script>
        // Fetch data from the API and display it
        fetch('../api/api.php')
            .then(response => response.json())
            .then(data => {
                const agentData = document.getElementById('agentData');
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = JSON.stringify(item);
                    agentData.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
