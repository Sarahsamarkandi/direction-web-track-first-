<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Replace with the actual password if you have one
$dbname = "button_clicks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that the 'choice' parameter is set and not empty
    if (isset($_POST['choice']) && !empty($_POST['choice'])) {
        $choice = $_POST['choice'];

        // Prepare the SQL statement
        $sql = "INSERT INTO clicks (button_name) VALUES (?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameter and execute the statement
            $stmt->bind_param("s", $choice);

            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Execute error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Prepare error: " . $conn->error;
        }
    } else {
        echo "Error: choice is empty.";
    }
} else {
    echo "Error: not a POST request.";
}

// Close the connection
$conn->close();
?>
