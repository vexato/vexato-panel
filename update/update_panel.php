<!-- update/update_panel.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Panel</title>
    <script>
        function checkForUpdates() {
            fetch('update/check_update.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'update_available') {
                        document.getElementById('updateMessage').innerText = 'New version available: ' + data.latest_version;
                        document.getElementById('updateButton').style.display = 'block';
                    } else {
                        document.getElementById('updateMessage').innerText = 'Your panel is up to date.';
                        document.getElementById('updateButton').style.display = 'none';
                    }
                });
        }

        function applyUpdates() {
            fetch('update/update.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'update_successful') {
                        document.getElementById('updateMessage').innerText = 'Update successful to version ' + data.new_version;
                    } else {
                        document.getElementById('updateMessage').innerText = 'Update failed.';
                    }
                    document.getElementById('updateButton').style.display = 'none';
                });
        }
    </script>
</head>
<body>
    <h1>Update Panel</h1>
    <button onclick="checkForUpdates()">Check for Updates</button>
    <div id="updateMessage"></div>
    <button id="updateButton" style="display: none;" onclick="applyUpdates()">Update Now</button>
</body>
</html>
