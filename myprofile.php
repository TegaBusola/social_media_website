<?php
session_start();

// Include database connection file
require_once "db_connection.php";

// Retrieve user's profile information
$user_id = $_SESSION['email'];

// Prepare and execute statement to retrieve user's profile information
$stmt = $conn->prepare("SELECT users.first_name, users.last_name, users.email, profile.biography FROM users INNER JOIN profile ON users.email = profile.email WHERE users.email = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

// Fetch user's profile information
$row = $result->fetch_assoc();
$first_name = htmlspecialchars($row['first_name']);
$last_name = htmlspecialchars($row['last_name']);
$email = htmlspecialchars($row['email']);
$biography = htmlspecialchars($row['biography']);

// Close statement and database connection
$stmt->close();
$conn->close();
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
        .profile img {
            width: 150px; /* Set the width of the profile picture */
            height: 150px; /* Set the height of the profile picture */
            border-radius: 50%; /* Make the picture round */
            margin-bottom: 10px;
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
            <a class="bio-link" href="dashboard.php">Bio Update</a>
            <a class="timeline-link" href="browse.php">Timeline</a>
            <a class="logout-button" href="create_account.html">Logout</a>
        </div>
    </div>
<body>
    <div class="profile">
        <img src="grey_silhouette_image.jpg" alt="Profile Picture">
        <h2><?php echo $first_name . " " . $last_name; ?></h2>
        <p>Email: <?php echo $email; ?></p>
        <p>Biography: <?php echo $biography; ?></p>
    </div>
</body>
</html>
