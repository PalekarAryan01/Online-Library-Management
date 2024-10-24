<?php
session_start();
include "connect.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Store user data
} else {
    echo "<script>alert('User not found.'); window.location.href='userdash.php';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            
        }
        .form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        .form img{
            height:80px;
            width:180px;
            margin-left:110px;
        }
        .input-block {
            margin-bottom: 20px;
        }
        .input-block label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .input-block input,
        .input-block select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button {
            background-color: royalblue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }
        .button:hover {
            background-color: royalblue;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form class="form" method="post" action="update_profile.php" onsubmit="return validateForm()">
        <img src="Images/nirmalalogowithname.png" class="logo">
        <h1>Edit Your Profile</h1>
        <div class="input-block">
            <label for="fName">Enter Your First Name</label>
            <input class="input" type="text" id="fName" name="fname" value="<?php echo htmlspecialchars($user['Fname'], ENT_QUOTES, 'UTF-8'); ?>" required="">
            <small id="fNameError" class="error-message"></small>
        </div>
        <div class="input-block">
            <label for="lName">Enter Your Last Name</label>
            <input class="input" type="text" id="lName" name="lname" value="<?php echo htmlspecialchars($user['Lname'], ENT_QUOTES, 'UTF-8'); ?>" required="">
            <small id="lNameError" class="error-message"></small>
        </div>
        <div class="input-block">
            <label for="Course">Select Course</label>
            <select id="Course" name="Course" required>
                <option value="" disabled>Select Course</option>
                <option value="CS" <?php if ($user['course'] == 'CS') echo 'selected'; ?>>Computer Science</option>
                <option value="IT" <?php if ($user['course'] == 'IT') echo 'selected'; ?>>Information Technology</option>
                <option value="BMM" <?php if ($user['course'] == 'BMM') echo 'selected'; ?>>Bachelor Of Mass Media</option>
                <option value="BCOM" <?php if ($user['course'] == 'BCOM') echo 'selected'; ?>>Bachelor Of Commerce</option>
            </select>
            <small id="CourseError" class="error-message"></small>
        </div>
        <div class="input-block">
            <label for="lid">Library ID No.</label>
            <input class="input" type="text" id="lid" name="Lid" value="<?php echo htmlspecialchars($user['Lid'], ENT_QUOTES, 'UTF-8'); ?>" required="">
            <small id="lidError" class="error-message"></small>
        </div>
        
        <div class="input-block">
            <button type="submit" class="button" name="submit">Update</button>
        </div>
        <div id="error" class="error"></div>
    </form>
    <script>
        function validateForm() {
            var isValid = true;

            // Clear previous error messages
            var errorElements = document.getElementsByClassName("error-message");
            while (errorElements[0]) {
                errorElements[0].parentNode.removeChild(errorElements[0]);
            }

            // Retrieve form data
            var fName = document.getElementById("fName").value.trim();
            var lname = document.getElementById("lName").value.trim();
            
            var course = document.getElementById("Course").value.trim();
            var lid = document.getElementById("lid").value.trim();
            var password = document.getElementById("password").value.trim();
            var confirmPassword = document.getElementById("confirmPassword").value.trim();

            // Validation
            if (fName === "") {
                showError("fName", "First Name is required.");
                isValid = false;
            }

            if (lname === "") {
                showError("lName", "Last Name is required.");
                isValid = false;
            }

            

            if (course === "") {
                showError("Course", "Course is required.");
                isValid = false;
            }

            if (lid === "") {
                showError("lid", "Library ID is required.");
                isValid = false;
            }

            if (password === "") {
                showError("password", "Password is required.");
                isValid = false;
            } else if (password.length < 6) {
                showError("password", "Password must be at least 6 characters long.");
                isValid = false;
            }

            if (password !== confirmPassword) {
                showError("confirmPassword", "Passwords do not match.");
                isValid = false;
            }

            // Check if age is 18+
            var birthDate = new Date(date);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var month = today.getMonth() - birthDate.getMonth();

            if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18) {
                showError("date", "You must be at least 18 years old.");
                isValid = false;
            }

            return isValid;
        }

        function showError(inputId, message) {
            var inputElement = document.getElementById(inputId);
            var errorElement = document.createElement("small");
            errorElement.className = "error-message";
            errorElement.innerText = message;
            inputElement.parentNode.appendChild(errorElement);
        }
    </script>
    
    
    </body>
</html>

