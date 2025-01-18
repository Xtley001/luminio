<?=

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = sha1($_POST['password']);
$address = $_POST['address'];
$telephone = $_POST['telephone'];

// Database credentials
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$db_password = ''; // Database password
$database = 'luminio'; // Database name

// Create connection
$conn = new mysqli($host, $username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$sql = "INSERT INTO users (first_name, last_name, email, password, address, telephone) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $address, $telephone);

    // Execute the query
    if ($stmt->execute()) {
        // Set session data
        $_SESSION['user_id'] = $stmt->insert_id; // Last inserted ID
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['email'] = $email;

        // Redirect to home.html
        header("Location: /luminio/home.html");
        exit(); // Ensure no further code runs after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the connection
$conn->close();

?>