<?php
// Include the database connection file
include 'db_connection.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and sanitize
    $interaction_id = $_POST["interaction_id"];
    $comment_content = trim($_POST["comment_content"]);
    $commenter_email = trim($_POST["commenter_email"]);

    // Insert comment into comments table
    $sql = "INSERT INTO comments (interaction_id, comment_content, commenter_email) 
            VALUES ('$interaction_id', '$comment_content', '$commenter_email')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page where the comment was made
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
