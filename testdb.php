<?php
$conn = mysqli_connect('localhost', 'root', '', '', 3307);
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}
echo "Connected successfully on port 3307!";
?>