<?php
include "connect.php";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve Books data
    $isbn = isset($_POST["isbn"]) ? $_POST["isbn"] : ''; 
    $title = isset($_POST["title"]) ? $_POST["title"] : ''; 
    $author = isset($_POST["author"]) ? $_POST["author"] : ''; 
    $bookLocation = isset($_POST["bookLocation"]) ? $_POST["bookLocation"] : ''; 
    $availbilty = isset($_POST["availbilty"]) ? $_POST["availbilty"] : ''; 
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : ''; 
    $price = isset($_POST["price"]) ? $_POST["price"] : ''; 

    
    // Prepare SQL query
    $sql = "INSERT INTO books (id, title, author, available, quantity, booklocation, price) 
            VALUES ('$isbn', '$title', '$author', '$availbilty','$quantity', '$bookLocation', '$price')";

     // Execute SQL query
     if (mysqli_query($conn, $sql)) {
        // Redirect to login page after successful registration
        header("Location: addBook.html");
        exit(); // Make sure to exit after redirection
    } else {
        // Print error message if query execution fails
        echo "Error: " . mysqli_error($conn);
    }

     // Close database connection
     mysqli_close($conn);

}


?>