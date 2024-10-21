<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "shopping_cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$xml = simplexml_load_file('student.xml');

if ($xml === false) {
    die("Error loading XML file");
}

$stmt = $conn->prepare("INSERT INTO student (name, age, email) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $age, $email); 

foreach ($xml->student as $student) {
    $name = (string) $student->name;
    $age = (int) $student->age;
    $email = (string) $student->email;

    if (!$stmt->execute()) {
        echo "Error inserting record: " . $stmt->error . "\n";
    }
}

$stmt->close();
$conn->close();

echo "Data imported to MySql successfully!";
?>
