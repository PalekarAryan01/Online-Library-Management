<?php
include "connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the reservation
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation deleted successfully.'); window.location.href='admin_reserved_books.php';</script>";
    } else {
        echo "<script>alert('Error deleting reservation.'); window.location.href='admin_reserved_books.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
