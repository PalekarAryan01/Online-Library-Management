<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = isset($_POST["fname"]) ? $_POST["fname"] : '';
    $lastName = isset($_POST["lname"]) ? $_POST["lname"] : '';
    $category = isset($_POST["category"]) ? $_POST["category"] : '';
    $lid = isset($_POST["Lid"]) ? $_POST["Lid"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    
   

    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "library");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL query
    $sql = "INSERT INTO user (Fname, Lname, Category, Lid, password) 
            VALUES ('$firstName', '$lastName', '$category', '$lid', '$password')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Redirect to login page after successful registration
        header("Location: login.html");
        exit(); // Make sure to exit after redirection
    } else {
        // Print error message if query execution fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
