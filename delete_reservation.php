<?php
include "connect.php";

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    // SQL query to delete the specific reservation
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation deleted successfully.'); window.location.href='admin_reserved_books.php';</script>";
    } else {
        echo "<script>alert('Error deleting reservation.'); window.location.href='admin_reserved_books.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
