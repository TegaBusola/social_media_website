<?php
// Include database connection file
require_once "db_connection.php";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and sanitize
    $content = trim($_POST["content"]);
    $email = trim($_POST["email"]);

    // Check content length
    if (strlen($content) > 280) {
        $error = "Content exceeds 280 characters limit.";
    } else {
        // Insert post into interactions table with current timestamp
        $timestamp = date('Y-m-d H:i:s'); // Current date and time
        $sql = "INSERT INTO interactions (content, email, timestamp) VALUES ('$content', '$email', '$timestamp')";
        if ($conn->query($sql) === TRUE) {
            // Redirect to refresh the page and avoid resubmission
            header("Location: browse.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Delete post if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM interactions WHERE id=$delete_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: browse.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch previous posts
$sql = "SELECT id, content, email, timestamp FROM interactions ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; /* Center align content */
        }
        .header {
            background-color: #f2f2f2;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .header h5 {
            margin: 0;
        }
        .logout-button,
        .profile-link {
            margin-left: 20px;
        }
        .content {
            margin: 0 auto; /* Center the content horizontally */
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: left; /* Align content to left */
        }
        .post {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .comment {
            margin-left: 20px;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .like-form,
        .comment-form,
        .delete-form {
            display: inline-block;
            margin-right: 10px; /* Add margin between buttons */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Friendzone</h1>
            <h5><em>The site built for community</em></h5>
        </div>
        <div>
            <a class="profile-link" href="myprofile.php">My Profile</a>
            <a class="logout-button" href="create_account.html">Logout</a>
        </div>
    </div>
    <div class="content">
        <h2>Your Timeline</h2>
        <form class="post-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <textarea name="content" rows="4" cols="50" maxlength="280" required></textarea><br>
            <input type="email" name="email" placeholder="Your Email" required><br>
            <input type="submit" value="Post">
        </form>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        
        <div class="timeline-posts">
            <h2>Previous Posts</h2>
            <?php
            // Display timeline posts with comment form and like button
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p><strong>" . $row["email"]. "</strong> - " . $row["timestamp"]. "<br>" . $row["content"]. "</p>";
                
                // Fetch comments for this post
                $post_id = $row['id'];
                $comment_sql = "SELECT commenter_email, comment_content, timestamp FROM comments WHERE interaction_id=$post_id ORDER BY timestamp DESC";
                $comment_result = $conn->query($comment_sql);
                if ($comment_result->num_rows > 0) {
                    echo "<div class='comments'>";
                    echo "<h3>Comments</h3>";
                    while ($comment_row = $comment_result->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<p><strong>" . $comment_row["commenter_email"]. "</strong> - " . $comment_row["timestamp"]. "<br>" . $comment_row["comment_content"]. "</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
                
                // Comment form
                echo "<form class='comment-form' method='post' action='comment.php'>";
                echo "<input type='hidden' name='interaction_id' value='" . $row["id"] . "'>";
                echo "<input type='email' name='commenter_email' placeholder='Your Email' required><br>";
                echo "<textarea name='comment_content' rows='2' cols='30' maxlength='100' required></textarea><br>";
                echo "<input type='submit' value='Comment'>";
                echo "</form>";
                
                // Like button
                echo "<form class='like-form' method='post' action='like.php'>";
                echo "<input type='hidden' name='interaction_id' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='liker_email' value='" . $row["email"] . "'>"; // Assuming the post owner can't like their own post
                echo "<button type='submit' name='like'>❤️</button>";
                echo "</form>";
                
                // Delete button (for the user's own posts)
                echo "<form class='delete-form' method='get' action='browse.php'>";
                echo "<input type='hidden' name='delete' value='" . $row["id"] . "'>";
                echo "<input type='submit' value='Delete'>";
                echo "</form>";
                
                echo "</div>";
            }
            ?>
        </div>
    
    <?php
    if ($result->num_rows === 0) {
        echo "<p>No previous posts.</p>";
    }
    ?>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
