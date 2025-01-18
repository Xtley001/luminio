<?=
// Start session
session_start();

// Database credentials
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'luminio'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email and password from POST request
$email = $_POST['email'];
$password = sha1($_POST['password']); // Hash the password using SHA-1

// Prepare and execute the query
$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found
        $user = $result->fetch_assoc();
        
        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];

        // Redirect to home.html
        header("Location: /luminio/home.html");
        exit();
    } else {
        // Invalid credentials, redirect back to signin.html
        header("Location: /luminio/signin.html");
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the connection
$conn->close();

?>