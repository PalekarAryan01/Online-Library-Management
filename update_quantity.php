<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id']; // Assuming you are using user_id to identify users

    // Check if the user has already reserved the book
    $sql_check = "SELECT * FROM reservations WHERE book_id = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $book_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        // User hasn't reserved the book before, so decrease the quantity
        $sql_update = "UPDATE books SET quantity = quantity - 1 WHERE id = ? AND quantity > 0";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $book_id);

        if ($stmt_update->execute()) {
            // Insert reservation record
            $sql_reserve = "INSERT INTO reservations (book_id, user_id) VALUES (?, ?)";
            $stmt_reserve = $conn->prepare($sql_reserve);
            $stmt_reserve->bind_param("ii", $book_id, $user_id);

            if ($stmt_reserve->execute()) {
                echo "Reservation successful!";
            } else {
                echo "Error: " . $stmt_reserve->error;
            }
        } else {
            echo "Error updating book quantity: " . $stmt_update->error;
        }
    } else {
        echo "User has already reserved this book.";
    }

    $stmt_check->close();
    $stmt_update->close();
    $stmt_reserve->close();
}

$conn->close();
?>
