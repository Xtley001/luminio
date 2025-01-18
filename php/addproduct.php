<?php
session_start();

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$unit = $_POST['unit'];
$rating = $_POST['rating'];

// Database credentials
$host = 'localhost';
$username = 'root';
$db_password = '';
$database = 'luminio';

// Create connection
$conn = new mysqli($host, $username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$sql = "INSERT INTO products (name, price, unit, description, rating) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssd", $name, $price, $unit, $description, $rating);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $name;
        $_SESSION['price'] = $price;
        $_SESSION['description'] = $description;
        $_SESSION['rating'] = $rating;
        $_SESSION['unit'] = $unit;

        header("Location: /luminio/addproduct.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
