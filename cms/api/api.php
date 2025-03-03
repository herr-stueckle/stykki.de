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

// SQL-Abfrage, um Bilder nach Projekt zu gruppieren
$sql = "SELECT img_project,
               JSON_ARRAYAGG(JSON_OBJECT('img_name', img_name, 
                                         'img_description', img_description, 
                                         'img_date', img_date, 
                                         'img_path', img_path)) AS grouped_data
        FROM images
        GROUP BY img_project;";





$result = $conn->query($sql);

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}


// JSON-Ausgabe
header('Content-Type: application/json');
echo stripslashes(json_encode($data));

$conn->close();
?>
