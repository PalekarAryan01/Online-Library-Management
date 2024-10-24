<?php
include "connect.php";

// Fetch only reserved books
$sql = "SELECT reservations.book_id, books.title, books.author, books.quantity, 
               books.quantity - COUNT(reservations.book_id) AS availability, 
               reservations.id AS reservation_id, reservations.user_name, reservations.reservation_date, reservations.checkout_time 
        FROM reservations 
        JOIN books ON reservations.book_id = books.id 
        GROUP BY reservations.book_id, reservations.id, reservations.user_name, reservations.reservation_date, reservations.checkout_time";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Function to check and update reservation status
function checkReservationStatus($conn) {
    $currentDate = date('Y-m-d');
    $sql = "UPDATE reservations SET status='expired' WHERE reservation_date < '$currentDate' AND status='active'";
    $conn->query($sql);
}

// Call the function to update reservation status
checkReservationStatus($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Reserved Books</title>
    <style>
        .table-container {
            overflow-x: auto;
            margin: 20px 0;
        }

        h1{
            text-align:center;
            color: #333;
            font-size:40px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            text-align: left;
            margin-top:40px
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: royalblue;
            color: white;
        }

        button {
            background-color: royalblue;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <h1>Reserved Books and Availability</h1>
    <table border="1">
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Availability</th>
            <th>Quantity</th>
            <th>Reserved By</th>
            <th>Reservation Date</th>
            <th>Checkout Point</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["book_id"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . ($row["availability"] > 0 ? "Available" : "Not Available") . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . ($row["user_name"] ? $row["user_name"] : "N/A") . "</td>";
                echo "<td>" . ($row["reservation_date"] ? $row["reservation_date"] : "N/A") . "</td>";
                echo "<td>" . ($row["checkout_time"] ? $row["checkout_time"] : "N/A") . "</td>";
                echo "<td>
                        <button onclick=\"editBook(" . $row['book_id'] . ")\">Edit</button>
                        <button onclick=\"deleteReservation(" . $row['reservation_id'] . ")\">Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No reservations found</td></tr>";
        }
        ?>
    </table>

    <script>
        function editBook(book_id) {
            // Redirect to edit page with book ID
            window.location.href = 'edit_book.php?id=' + book_id;
        }

        function deleteReservation(reservation_id) {
            if (confirm('Are you sure you want to delete this reservation?')) {
                // Redirect to delete page with reservation ID
                window.location.href = 'delete_reservation.php?reservation_id=' + reservation_id;
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
