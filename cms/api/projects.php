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


$sql = "SELECT p.pro_id, 
               p.pro_name, 
               p.pro_name_en, 
               p.pro_ratio, 
               p.pro_year,
               p.pro_camera,
               p.pro_description,
               p.pro_description_en,
               JSON_ARRAYAGG(JSON_OBJECT('img_name', i.img_name,
                                         'img_name_en', i.img_name_en,
                                         'img_description', i.img_description, 
                                         'img_description_en', i.img_description_en,
                                         'img_date', i.img_date, 
                                         'img_path', i.img_path,
                                         'img_folder', i.img_folder, 
                                         'img_thumb_folder', i.img_thumb_folder,
                                         'img_height', i.img_height, 
                                         'img_width', i.img_width)) AS images
        FROM projects AS p
        JOIN images AS i ON p.pro_name = i.img_project -- Ensure this is the correct join condition
        GROUP BY p.pro_id,
                 p.pro_name, 
                 p.pro_name_en, 
                 p.pro_ratio, 
                 p.pro_year, 
                 p.pro_camera, 
                 p.pro_description, 
                 p.pro_description_en
        ORDER BY p.pro_id;";  // Ensure all non-aggregated columns are included.

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
