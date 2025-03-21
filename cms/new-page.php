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
  $page_title = $_POST['page_title'];
  $page_title_en = $_POST['page_title_en'];
  $page_content= $_POST['page_content'];
  $page_content_en= $_POST['page_content_en'];

  $stmt = $conn->prepare("INSERT INTO pages (title, title_en, content, content_en) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $page_title, $page_title_en, $page_content, $page_content_en); // Daten binden

  if ($stmt->execute()) {

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

    <!-- Initialize Quill editor -->

    <div class="container">
      <form action="new-page.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-4">
            <label for="page_title">Seietentitel</label>
            <input type="text" name="page_title" id="page_title" required>
            <label for="page_title_en"></label>
            <input type="text" name="page_title_en" id="page_title_en" placeholder="english">
          </div>
          <div class="col-8">
            <label for="page_content">Beschreibung</label>
            <textarea name="page_content" id="page_content" rows="20" required></textarea>
            <br>
            <textarea name="page_content_en" id="page_content_en" rows="3" placeholder="english"></textarea>
            <input type="submit" value="anlegen">
          </div>
        </div>
      </form>
    </div>

    <script>
      $(document).ready(function () {
        $('#page_content').summernote({
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
        $('#page_content_en').summernote({
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


  </div>


</body>

</html>