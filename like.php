<?php
// Include the database connection file
include 'db_connection.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and sanitize
    $interaction_id = $_POST["interaction_id"];
    $liker_email = trim($_POST["liker_email"]);

    // Insert like into likes table
    $sql = "INSERT INTO likes (interaction_id, liker_email) 
            VALUES ('$interaction_id', '$liker_email')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page where the like was made
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
