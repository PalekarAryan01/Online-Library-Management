<?php
session_start();
if (isset($_SESSION['Admin'])) {
    header('location:login.html');
    exit();
}

include "connect.php";

if (isset($_POST['signIn'])) {
    $Lid = trim($_POST["Lid"]);
    $password = trim($_POST["password"]);
    $errors = [];

    // Validate Library ID
    if (empty($Lid)) {
        $errors[] = "Library ID is required.";
    }

    // Validate Password
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        // SQL query to check if the credentials are valid
        $sql = "SELECT * FROM user WHERE Lid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $Lid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id']; // Store user ID in session

            if ($row["Category"] == "Student") {
                $_SESSION['Fname'] = $row['Fname']; 
                $_SESSION['Lname'] = $row['Lname'];
                header('location: dashboard.php');
            } elseif ($row["Category"] == "Admin") {
                header('location: admin.php');
                $_SESSION['Fname'] = $row['Fname']; // Assuming $Fname is fetched from the database
            }
            exit();
        } else {
            echo "<script>alert('Invalid Library ID or Password.'); window.location.href='login.html';</script>";
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

$conn->close();
?>
