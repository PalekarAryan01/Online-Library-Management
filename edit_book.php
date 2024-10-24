<?php
include "connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the reservation details
    $sql = "SELECT books.title, books.author, reservations.user_name, reservations.reservation_date, reservations.checkout_time 
            FROM books 
            LEFT JOIN reservations ON books.id = reservations.book_id 
            WHERE books.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $author, $user_name, $reservation_date, $checkout_time);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Reservation</h1>
    <form method="post" action="update_reservation.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>" readonly>
        <label>Author:</label>
        <input type="text" name="author" value="<?php echo $author; ?>" readonly>
        <label>Reserved By:</label>
        <input type="text" name="user_name" value="<?php echo $user_name; ?>">
        <label>Reservation Date:</label>
        <input type="date" name="reservation_date" value="<?php echo $reservation_date; ?>">
        
        <label>Checkout Time:</label>
        <input type="time" name="checkout_time">
        <input type="submit" value="Update">
    </form>
</body>
</html>
