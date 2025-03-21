<?php
// Datenbankverbindung
$host = 'localhost'; // Ihre Datenbankhost
$dbname = 'herr-stueckle'; // Ihre Datenbankname
$username = 'root'; // Ihr Datenbankbenutzername
$password = 'root'; // Ihr Datenbankpasswort

$conn = new mysqli($host, $username, $password, $dbname);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Correct SQL query
$sql = "SELECT title, 
               title_en, 
               content, 
               content_en, 
               JSON_ARRAYAGG(JSON_OBJECT('title', title,
                                          'title_en', title_en,
                                          'content', content, 
                                          'content_en', content_en)) AS pages
        FROM pages";

// Ensure there's a GROUP BY clause if you're using aggregate functions
$sql .= " GROUP BY idx"; // Replace 'some_column' with the appropriate grouping column

$result = $conn->query($sql);

// Check for SQL errors
if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

// Initialize the array to hold data
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON-Ausgabe
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>