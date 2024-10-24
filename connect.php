
<?php
$host="localhost:3307";
$user="root";
$pass="";
$db="library";

$conn=new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}else{
    // echo "Connection Succesfull";
}

?>

