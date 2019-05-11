<?php

$servername = "localhost";
$username = "test";
$password = "test";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT ID, name, email, phone FROM test";

$result = $conn->query($sql);

//echo $result->name;

//echo $result->num_rows;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row['name']. " " . $row['email'] . " " . $row['phone'] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();