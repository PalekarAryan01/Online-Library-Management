<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $user_name = isset($_SESSION['Fname']) ? $_SESSION['Fname'] : "Guest";
    $checkout_time = isset($_POST['checkout_time']) ? $_POST['checkout_time'] : '';
    $reservation_date = date('Y-m-d H:i:s'); 

    // Check if the user has already reserved the book
    $sql_check = "SELECT * FROM reservations WHERE book_id = ? AND user_name = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("is", $book_id, $user_name);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        // Insert the reservation
        $sql_reserve = "INSERT INTO reservations (book_id, user_name, reservation_date, checkout_time) VALUES (?, ?, ?, ?)";
        $stmt_reserve = $conn->prepare($sql_reserve);

        if ($stmt_reserve) {
            $stmt_reserve->bind_param("isss", $book_id, $user_name, $reservation_date, $checkout_time);
            
            if ($stmt_reserve->execute()) {
                echo "<script>alert('Reservation successful by $user_name!'); window.location.href=document.referrer;</script>";
            } else {
                echo "<script>alert('Error: " . $stmt_reserve->error . "'); window.location.href=document.referrer;</script>";
            }

            // Update book quantity
            $sql_update = "UPDATE books SET quantity = quantity - 1 WHERE id = ? AND quantity > 0";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $book_id);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            echo "<script>alert('Error preparing statement.'); window.location.href=document.referrer;</script>";
        }
        
        $stmt_reserve->close();
    } else {
        echo "<script>alert('You have already reserved this book.'); window.location.href=document.referrer;</script>";
    }

    $stmt_check->close();
}

$conn->close();
?>
