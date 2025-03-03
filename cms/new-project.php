<?php
$host = 'localhost'; // Ihre Datenbankhost
$dbname = 'herr-stueckle'; // Ihre Datenbankname
$username = 'root'; // Ihr Datenbankbenutzername
$password = 'root'; // Ihr Datenbankpasswort

// Verbindung zur Datenbank
$conn = new mysqli($host, $username, $password, $dbname);

// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
  die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pro_name = $_POST['pro_name'];
  $pro_name_en = $_POST['pro_name_en'];
  $pro_year = $_POST['pro_year'];
  $pro_camera = $_POST['pro_camera'];
  $pro_description = $_POST['pro_description'];
  $pro_description_en = $_POST['pro_description_en'];

  $stmt = $conn->prepare("INSERT INTO projects (pro_name, pro_name_en, pro_year, pro_camera, pro_description, pro_description_en) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param("ssssss", $pro_name, $pro_name_en, $pro_year, $pro_camera, $pro_description, $pro_description_en ); // Daten binden

  if ($stmt->execute()) {
    echo "Neues Projekt wurde angelegt";
  } else {
    echo "Fehler: " . $stmt->error;
  }
  $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<?php
include './snippets/head.html';
?>

<body>
  <div class="hs-cms-wrapper">
    <header class="black">
      <?php
      include './snippets/nav.html';
      ?>
    </header>
    <div class="container">
      <form action="new-project.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-4">
            <label for="pro_name">Projektname</label>
            <input type="text" name="pro_name" id="pro_name" required>
            <label for="pro_name_en"></label>
            <input type="text" name="pro_name_en" id="pro_name_en" placeholder="english">
            <br>
            <hr>
            <label for="pro_year">Jahr</label>
            <input type="text" name="pro_year" id="pro_year" required>
            <label for="pro_camera">Kamera</label>
            <input type="text" name="pro_camera" id="pro_camera" required>
          </div>
          <div class="col-8">
          <label for="pro_description">Beschreibung</label>
          <textarea name="pro_description" id="pro_description" rows="20" required></textarea>
          <br>
          <textarea name="pro_description_en" id="pro_description_en" rows="3"  placeholder="english"></textarea>
          <input type="submit" value="anlegen">
          </div>
        </div>
      </form>
    </div>


  </div>


</body>

</html>