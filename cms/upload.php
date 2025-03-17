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
    $img_name_en = $_POST['img_name_en'];
    $img_description = $_POST['img_description'];
    $img_description_en = $_POST['img_description_en'];
    $img_date = $_POST['img_date'];
    // Bild hochladen
    $targetDir = "data/"; // Verzeichnis für Uploads


    $targetDirThumbs = $targetDir . $img_project . '/thumbs';

    if (!is_dir($targetDir . $img_project)) {
        mkdir($targetDirThumbs . '/25', 0777, true);
        mkdir($targetDirThumbs . '/10', 0777, true);
    } 
    
    $targetDir = $targetDir . $img_project . '/' ;
    
    $targetFile = date('m-d-Y-His') . '-' . basename($_FILES["bild"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Überprüfen, ob es sich um ein Bild handelt
    $check = getimagesize($_FILES["bild"]["tmp_name"]);
    list($img_width, $img_height) = getimagesize($_FILES["bild"]["tmp_name"]);


    if ($check === false) {

        $toastMessage = "Datei ist kein Bild.";
        $uploadOk = 0;
    }

    // Überprüfen, ob die Datei bereits existiert
    if (file_exists($targetFile)) {
        $toastMessage = "Sorry, Datei existiert bereits.";

    }


    // Überprüfen der Dateigröße
    if ($_FILES["bild"]["size"] > 50000000) {
        $toastMessage = "Sorry, Ihre Datei ist zu groß.";
        $uploadOk = 0;
    }

    // Erlaubte Dateiformate
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $toastMessage = "Sorry, nur JPG, JPEG, PNG & GIF Dateien sind erlaubt.";
        $uploadOk = 0;
    }

    // Überprüfen, ob $uploadOk auf 0 gesetzt wurde
    if ($uploadOk == 0) {
        $toastMessage = $toastMessage . ". " . "Sorry, Ihre Datei wurde nicht hochgeladen.";
    } else {

       

        

        if (move_uploaded_file($_FILES["bild"]["tmp_name"],  $targetDir . $targetFile)) {
            // Daten in die Datenbank einfügen
            $stmt = $conn->prepare("INSERT INTO images (img_path, img_folder, img_thumb_folder, img_project, img_name, img_name_en, img_description, img_description_en, img_date, img_width, img_height) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssss", $targetFile, $targetDir, $targetDirThumbs, $img_project, $img_name, $img_name_en, $img_description, $img_description_en, $img_date, $img_width, $img_height); // Daten binden

            if ($stmt->execute()) {
                $toastMessage = "Die Datei wurde hochgeladen und die Informationen wurden in die Datenbank gespeichert.";

                $percent_25 = 25;
                $percent_10 = 10;
        
                $ratio = $img_width / $img_height;
        
                $new_img_width_25 = intdiv($img_width , $percent_25);
                $new_img_height_25 = intdiv($img_height , $percent_25); 

                $new_img_width_10 = intdiv($img_width , $percent_10);
                $new_img_height_10 = intdiv($img_height , $percent_10);
        
        
        
                $source = imagecreatefromjpeg($targetDir .$targetFile );
                $thumb_25 = imagecreatetruecolor($new_img_width_25, $new_img_height_25);
                $thumb_10 = imagecreatetruecolor($new_img_width_10, $new_img_height_10);
        
                imagecopyresized($thumb_25, $source, 0, 0, 0, 0, $new_img_width_25, $new_img_height_25, $img_width, $img_height);
                imagecopyresized($thumb_10, $source, 0, 0, 0, 0, $new_img_width_10, $new_img_height_10, $img_width, $img_height);
        
                // Save the resized image
                imagejpeg($thumb_25,  $targetDirThumbs . '/' . '25/' . date('m-d-Y-His') . '-' . basename($_FILES["bild"]["name"], 100));
                imagejpeg($thumb_10,  $targetDirThumbs . '/' . '10/' . date('m-d-Y-His') . '-' . basename($_FILES["bild"]["name"], 100));

            } else {
                $toastMessage = "Fehler: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $toastMessage = "Sorry, beim Hochladen Ihrer Datei ist ein Fehler aufgetreten.";
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
    <div class="hs-cms-wrapper">

        <header class="black">
            <?php
            include './snippets/nav.html';
            ?>
        </header>

        <div class="container">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-4">
                        <input id="img" type="file" name="bild" required accept="image/*"><br>
                        <img id="preview" src="#" alt="Vorschau"
                            style="display: none; max-width: 300px; max-height: 300px;">
                    </div>
                    <div class="col-8">
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
                        <label for="img_name">Titel</label>
                        <input type="text" name="img_name" id="img_name" required>
                        <label for="img_name_en"></label>
                        <input type="text" name="img_name_en" id="img_name_en" required placeholder="English">
                        <label for="pro_description">Beschreibung</label>
                        <textarea name="img_description" id="img_description" required></textarea>
                        <label for="img_description_en"></label>
                        <textarea name="img_description_en" id="img_description_en" required
                            placeholder="English"></textarea>
                        <label for="img_date">Datum</label>
                        <input type="text" name="img_date" id="img_date" required>
                        <input type="submit" value="Hochladen">


                    </div>
                </div>
            </form>
        </div>


        <?php
        echo $toastMessage;
        ?>
    </div>

    <script>
      
    </script>


    <script>
        const fileInput = document.getElementById('img');
        const previewImage = document.getElementById('preview');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    previewImage.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                previewImage.src = '#';
                previewImage.style.display = 'none';
            }
        });

        $(document).ready(function () {
        $('#img_description').summernote({
          height: 300,
          toolbar: [
            ['style', ['bold', 'italic']],
            ['fontsize', ['fontsize']],
            ['insert', ['link']],
            ['para', ['paragraph']],
            ['view', ['codeview']],
          ]
        });
      });

      $(document).ready(function () {
        $('#img_description_en').summernote({
          height: 300, toolbar: [
            ['style', ['bold', 'italic']],
            ['fontsize', ['fontsize']],
            ['insert', ['link']],
            ['para', ['paragraph']],
            ['view', ['codeview']],
          ]
        });
      });

    </script>

</body>

</html>