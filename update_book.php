<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $available = $_POST['available'];

    // Update book availability
    $sql = "UPDATE books SET available = $available WHERE id = $book_id";
    if ($conn->query($sql) === TRUE) {
        echo "Book availability updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
