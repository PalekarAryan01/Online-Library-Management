<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $user_name = $_POST['user_name'];
    $reservation_date = $_POST['reservation_date'];
    $checkout_time = $_POST['checkout_time'];

    // SQL query to update the reservation
    $sql = "UPDATE reservations SET user_name = ?, reservation_date = ?, checkout_time = ? WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssi", $user_name, $reservation_date, $checkout_time, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Reservation updated successfully.'); window.location.href='admin.php';</script>";
        } else {
            echo "<script>alert('Error updating reservation.'); window.location.href='admin.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href='admin_reserved_books.php';</script>";
    }
}

$conn->close();
?>
