<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = isset($_POST["fname"]) ? $_POST["fname"] : '';
    $lastName = isset($_POST["lname"]) ? $_POST["lname"] : '';
    $category = isset($_POST["role"]) ? $_POST["role"] : '';
    $lid = isset($_POST["Lid"]) ? $_POST["Lid"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $course = isset($_POST["course"]) ? $_POST["course"] : '';

    include "connect.php";

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $sql = "INSERT INTO user (Fname, Lname, Category, Lid, password, course) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $category, $lid, $hashedPassword, $course);

    // Execute SQL query
    if ($stmt->execute()) {
        // Display alert message after successful addition
        echo "<script>alert('User added successfully!'); window.location.href='addUser.html';</script>";
        exit(); // Make sure to exit after redirection
    } else {
        // Print error message if query execution fails
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
