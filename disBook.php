<?php
include "connect.php";

// Fetch books
$sql = "SELECT id, title, author, quantity FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Books</title>
    <style>
        /* -----------------------Table--------------------- */
table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        th, td {
            padding: 10px;
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
            background-color: #45a049;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#checkout_point").datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss'
            });
        });

        function reserveBook(bookId) {
            document.getElementById('book_id').value = bookId;
            document.getElementById('reserveForm').style.display = 'block';
        }
    </script>
</head>
<body>
    <h1>Library Books</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>";
                if ($row["quantity"] > 0) {
                    echo "<button onclick='reserveBook(" . $row["id"] . ")'>Reserve</button>";
                } else {
                    echo "Not Available";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No books available</td></tr>";
        }
        ?>
    </table>

    <div id="reserveForm" style="display:none;">
        <h2>Reserve Book</h2>
        <form method="post" action="reserve.php">
            <input type="hidden" id="book_id" name="book_id">
            <label for="user_name">Your Name:</label>
            <input type="text" id="user_name" name="user_name" required><br><br>
            <label for="checkout_point">Checkout Point:</label>
            <input type="text" id="checkout_point" name="checkout_point" required><br><br>
            <input type="submit" value="Reserve">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
