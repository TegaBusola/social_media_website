<?php
// Start the session
session_start();

// Include database connection file
require_once "db_connection.php";

    // Prepare SQL statement to fetch user data based on email
    $sql = "SELECT email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $email);

    // Set parameters
    $email = $_POST["email"];

    // Execute the statement
    $stmt->execute();

    // Store the result
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST["password"], $row["password"])) {
            // Password is correct, set session variable for email and redirect to dashboard or home page
            $_SESSION["email"] = $row["email"];
            header("Location: browse.php"); // Redirect to timeline
            exit();
        } else {
            // Password is incorrect, display error message
            echo "<p>Invalid password.</p>";
        }
    } else {
        // User does not exist, display error message
        echo "<p>User not found.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

?>

