<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "shopping_cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, age, email FROM student";
$result = $conn->query($sql);

$xml = new SimpleXMLElement('<students/>');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student = $xml->addChild('student');
        $student->addChild('name', $row['name']);
        $student->addChild('age', $row['age']);
        $student->addChild('email', $row['email']);
    }
} else {
    echo "No records found.";
}

$xml->asXML('students.xml');

$conn->close();

echo "Data exported to students.xml successfully!";
?>
