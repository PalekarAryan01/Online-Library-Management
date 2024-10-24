<?php
session_start();
include "connect.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $fName = $_POST['fname'];
    $lName = $_POST['lname'];
    $course = $_POST['Course'];
    $Lid = $_POST['Lid'];
    
    

    

    // SQL query to update the user's profile
    $sql = "UPDATE user SET Fname = ?, Lname = ?, Course = ?, Lid = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fName, $lName, $course, $Lid, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully.');</script>";
        // Redirect to the appropriate dashboard based on role
        if ($_SESSION['Category'] == 'Admin') {
            header('Location: admin.php');
        } else {
            header('Location: dashboard.php');
        }
        exit();
    } else {
        echo "<script>alert('Error updating profile.'); window.location.href='edit_profile.php';</script>";
    }
    $stmt->close();
}
$conn->close();
?>
