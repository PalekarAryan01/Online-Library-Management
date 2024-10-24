<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = trim($_POST["fname"]);
    $lastName = trim($_POST["lname"]);
    $category = trim($_POST["role"]);
    $course = trim($_POST["Course"]);
    $lid = trim($_POST["Lid"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirmPassword"]);
    $errors = [];

    // Validate form data
    if (empty($firstName)) {
        $errors[] = "Firstname is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Lastname is required.";
    }
    if (empty($category)) {
        $errors[] = "Role is required.";
    }
    if (empty($course)) {
        $errors[] = "Course is required.";
    }
    if (empty($lid)) {
        $errors[] = "Library ID is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        include "connect.php";

        // Encrypt the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query
        $sql = "INSERT INTO user (Fname, Lname, Category, course, Lid, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $lastName, $category, $course, $lid, $hashedPassword);

        // Execute SQL query
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
            exit(); // Make sure to exit after redirection
        } else {
            // Print error message if query execution fails
            echo "Error: " . $stmt->error;
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>
