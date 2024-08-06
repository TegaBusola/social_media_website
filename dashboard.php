<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: create_account.html"); // Redirect to login page if not logged in
    exit();
}

// Logout process
if (isset($_POST["logout"])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the create_account.html page
    header("Location: create_account.html");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "friendzone";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's profile information
$email = $_SESSION["email"];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Initialize $bio with an empty string to prevent "Undefined array key 'bio'" warning
$bio = isset($row["bio"]) ? $row["bio"] : '';

// Update profile information if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_bio = $_POST["bio"];
    $new_phone_number = $_POST["phone_number"];

    // Check if there are any changes in the form data
    if ($bio != $new_bio || $row["phone_number"] != $new_phone_number) {
        // Prepare SQL statement to update user's profile information in both tables
        $update_sql = "UPDATE users
                       INNER JOIN profile ON users.email = profile.email
                       SET users.phone_number = ?, profile.biography = ?
                       WHERE users.email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sss", $new_phone_number, $new_bio, $email);

        // Execute the update statement
        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
        } else {
            echo "Error updating profile: " . $conn->error;
        }

        // Close update statement
        $update_stmt->close();
    } else {
        echo "No changes were made.";
    }
}

// Close connection
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
            display: flex;
            justify-content: center; /* Center align content horizontally */
        }
        .container {
            width: 600px; /* Set a fixed width for the container */
        }
        .header {
            background-color: #f2f2f2;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .header h5 {
            margin: 0;
        }
        .logout-button,
        .timeline-button {
            margin-left: 20px;
        }
        .content {
            margin-top: 50px; /* Adjust the top margin */
            padding: 20px;
            border: 1px solid #ccc;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Friendzone</h1>
                <h5><em>The site built for community</em></h5>
            </div>
            <div>
                <a class="profile-link" href="myprofile.php">My Profile</a>
                <a class="logout-button" href="create_account.html">Logout</a>
            </div>
        </div>
        <div class="content">
            <?php if(isset($success_message)) : ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <h2>Edit Profile</h2>
            <form method="POST" action="">
                <label for="bio">Biography:</label><br>
                <!-- Check if the "bio" key exists before echoing its value -->
                <textarea id="bio" name="bio" rows="6" cols="50"><?php echo $bio; ?></textarea><br>
                <label for="phone_number">Phone Number:</label><br>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $row["phone_number"] ?? ''; ?>"><br>
                <input type="submit" value="Update Profile">
            </form>
        </div>
    </div>
</body>
</html>

