<?php
// STEP 1: Set database connection variables
$servername = "localhost";
$username = "root";
$password = ""; // Replace with the password you're using in Workbench
$database = "sukitech_db";
$port = 3307;

// STEP 2: Create a connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// STEP 3: Check connection
if ($conn->connect_error) {
    die("<h2 style='color: red;'>Connection failed: " . $conn->connect_error . "</h2>");
}

// STEP 4: Check if form was submitted properly
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    // STEP 5: Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // STEP 6: Prepare SQL and insert
    $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Thank You - SukiTech</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .thankyou-box {
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                text-align: center;
            }
            .thankyou-box h1 {
                color: #0d6efd;
            }
            .thankyou-box p {
                color: #333;
            }
            .btn-home {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #0d6efd;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
            }
            .btn-home:hover {
                background-color: #0b5ed7;
            }
        </style>
    </head>
    <body>
        <div class='thankyou-box'>
            <h1>Thank You, $name!</h1>
            <p>Your message has been received successfully.<br>We’ll get back to you soon.</p>
            <a href='index.html' class='btn-home'>Back to Home</a>
        </div>
    </body>
    </html>";

    // Execute and close
    $stmt->execute();
    $stmt->close();
} else {
    echo "<h2 style='color: red;'>Invalid form submission.</h2>";
}

// STEP 7: Close connection
$conn->close();
?>
