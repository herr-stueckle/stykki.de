<?php
$host = 'localhost'; // Ihre Datenbankhost
$dbname = 'herr-stueckle'; // Ihre Datenbankname
$username = 'root'; // Ihr Datenbankbenutzername
$password = 'root'; // Ihr Datenbankpasswort

$toastMessage = '';

// Verbindung zur Datenbank
$conn = new mysqli($host, $username, $password, $dbname);

$sql = "SELECT pro_name FROM projects";
$result = $conn->query($sql);

// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Bild und Felder verarbeiten
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $img_project = $_POST['img_project'];
    $img_name = $_POST['img_name'];
    $img_description = $_POST['img_description'];
    $img_date = $_POST['img_date'];
    // Bild hochladen
    $targetDir = "data/"; // Verzeichnis für Uploads

    if (!is_dir($targetDir  . $img_project)) {
        mkdir($targetDir . '/' . $img_project);
       
    }

    $targetDir = $targetDir . $img_project .'/';
    $targetFile = $targetDir . date('m-d-Y-His') . '-' . basename($_FILES["bild"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Überprüfen, ob es sich um ein Bild handelt
    $check = getimagesize($_FILES["bild"]["tmp_name"]);
    if ($check === false) {

        $toastMessage = "Datei ist kein Bild.";
        $uploadOk = 0;
    }

    // Überprüfen, ob die Datei bereits existiert
    if (file_exists($targetFile)) {
        $toastMessage =  "Sorry, Datei existiert bereits.";
        
    }


    // Überprüfen der Dateigröße
    if ($_FILES["bild"]["size"] > 50000000) {
        $toastMessage =  "Sorry, Ihre Datei ist zu groß.";
         $uploadOk = 0;
    }

    // Erlaubte Dateiformate
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $toastMessage =  "Sorry, nur JPG, JPEG, PNG & GIF Dateien sind erlaubt.";
        $uploadOk = 0;
    }

    // Überprüfen, ob $uploadOk auf 0 gesetzt wurde
    if ($uploadOk == 0) {
        $toastMessage =  $toastMessage . ". " ."Sorry, Ihre Datei wurde nicht hochgeladen.";
    } else {
        if (move_uploaded_file($_FILES["bild"]["tmp_name"], $targetFile)) {
            // Daten in die Datenbank einfügen
            $stmt = $conn->prepare("INSERT INTO images (img_path, img_project, img_name, img_description, img_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $targetFile, $img_project, $img_name, $img_description, $img_date); // Daten binden
            
            if ($stmt->execute()) {
                $toastMessage = "Die Datei wurde hochgeladen und die Informationen wurden in die Datenbank gespeichert.";
            } else {
                $toastMessage = "Fehler: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $toastMessage =  "Sorry, beim Hochladen Ihrer Datei ist ein Fehler aufgetreten.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<?php
include './snippets/head.html';
?>
<body>

    <header class="black">
    <?php
      include './snippets/nav.html';
      ?>
  </header>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        
      <input id="img" type="file" name="bild" required accept="image/*"><br>

      <img id="preview" src="#" alt="Vorschau" style="display: none; max-width: 300px; max-height: 300px;">

        <script>
            const fileInput = document.getElementById('img');
            const previewImage = document.getElementById('preview');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                    }

                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#';
                    previewImage.style.display = 'none';
                }
            });
        </script>


        <select name="img_project" id="img_project" required>
            <option value="">Bitte wählen</option>
            <?php

            

            // Überprüfen, ob es Ergebnisse gibt und diese in das select-Element einfügen
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['pro_name'] . '">' . htmlspecialchars($row['pro_name']) . '</option>';
                }
            } else {
                echo '<option value="">Keine Projekte gefunden</option>';
            }
            ?>
        </select><br>

        img_name: <input type="text" name="img_name" required><br>
        img_description: <input type="text" name="img_description" required><br>
        img_date: <input type="text" name="img_date" required><br>
        <input type="submit" value="Hochladen">
    </form>
    <?php
        echo $toastMessage;
    ?>
    
</body>
</html>