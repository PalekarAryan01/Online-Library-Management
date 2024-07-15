<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $lid = $_POST['Lid'];
    $password = $_POST['password'];
    
    
    
    // Establish database connection
    $host="localhost";
    $user="root";
    $pass="";
    $db="library";
    
    $conn = mysqli_connect("localhost", "root", "", "library");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //validate connection
    $query="SELECT * FROM user where Lid='$lid' AND password='$password'";

    $result = $conn->query($query);

    if($result->num_rows == 1){
        //login Success
        header("Location: welcome.html");
        exit();
    }else{
        //Login failed
        header("Location: error.html");
        exit();
    }
    $conn->close();


}
?>
