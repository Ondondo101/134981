
<!DOCTYPE html>
<html>
<head>
    <title>Agent Packages</title>
</head>
<body>
    <h1>Agent Packages</h1>

    <!-- Table to display data -->
    <table id="packageTable">
        <tr>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Sending From</th>
            <th>Package Color</th>
            <th>Sending To</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        include 'connection.php';

        $mysqli = new mysqli($server, $user, $pass, $database);
        if($mysqli->connect_error) {
            exit('Could not connect');
        }

        $sql = "SELECT packageId, customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
            FROM agentpackages";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['customerName'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td>" . $row['sendingFrom'] . "</td>";
                echo "<td>" . $row['packageColor'] . "</td>";
                echo "<td>" . $row['sendingTo'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo '<td><button class="approve-btn" data-package-id="' . $row['packageId'] . '">Approve</button></td>';
                echo '<td><button class="dispatch-btn" data-package-id="' . $row['packageId'] . '">Dispatch</button></td>';
                echo '<td><button class="delivered-btn" data-package-id="' . $row['packageId'] . '">Delivered</button></td>';
                echo '<td><button class="undelivered-btn" data-package-id="' . $row['packageId'] . '">Undelivered</button></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No packages found.</td></tr>";
        }

        $mysqli->close();
        ?>
    </table>

    <script>
        // AJAX to handle package approval
        const approveButtons = document.querySelectorAll(".approve-btn");
        approveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const packageId = this.getAttribute('data-package-id');
                approvePackage(packageId);
            });
        });

            function approvePackage(packageId) {
                // Send an AJAX request to your server to update the status
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'approve_package.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Refresh the table after approval
                        refreshPackageTable();
                    }
                };
                xhr.send(`packageId=${packageId}`);
            }
        

        // AJAX to handle package dispatch
        const dispatchButtons = document.querySelectorAll(".dispatch-btn");
        dispatchButtons.forEach(button => {
            button.addEventListener('click', function() {
                const packageId = this.getAttribute('data-package-id');
                dispatchPackage(packageId);
            });
        });

        function dispatchPackage(packageId) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'dispatch_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after dispatch
                    refreshPackageTable();
                }
            };
            xhr.send(`packageId=${packageId}`);
        }
    </script>
</body>
</html>
