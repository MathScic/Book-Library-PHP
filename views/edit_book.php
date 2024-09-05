<?php 
require_once "../models/db.php";
require_once "../models/Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

//Verif si Id livre est passer en paramètre
if (isset($_GET['id'])) {
  $book -> id = $_GET['id'];

  //Récupérer les détails du livre. 
$stmt = $db->prepare("SELECT * FROM books WHERE id = :id LIMIT 0,1");
$stmt->bindParam(":id", $book->id);
$stmt->execute();
  $row = $stmt-> fetch(PDO:: FETCH_ASSOC);

  if ($row) {
    //Remplir les propriétés du livre 
    $book -> title = $row["title"];
    $book -> author = $row["author"];
    $book -> year = $row["year"];
    $book -> genre = $row["genre"];
  } else {
    echo "<p>Livre non trouvé.</p>";
    exit;
  }

  //Verif si form est soumis 
  if ($_SERVER["REQUEST_METHOD"] =="POST") {
    // MAJ les propriétés du livre 
    $book -> title = $_POST['title'];
    $book -> author = $_POST['author'];
    $book -> year = $_POST['year'];
    $book -> genre = $_POST['genre'];

  }

  //MAJ livre dans DB 
  if ($book->update()) {
    echo "<p>Le livre a été correctement mis a jour avec succès !</p>";
  } else {
    echo "<p>Erreur lors de la MAJ du livre.</p>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le livre</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <header>
    <h1>Modifier le livre</h1>
  </header>
  <main>
    <form method="POST" action="edit_book.php?id=<?php echo $book->id; ?>">
      <label for="title">Titre :</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($book->title); ?>" required> <br>
      <label for="author">Auteur :</label>
      <input type="text" name="author" value="<?php echo htmlspecialchars($book->author); ?>" required> <br>
      <label for="year">Année :</label>
      <input type="number" name="year" value="<?php echo htmlspecialchars($book->year); ?>" required> <br>
      <label for="genre">Genre :</label>
      <input type="text" name="genre" value="<?php echo htmlspecialchars($book->genre); ?>" required> <br>

      <input type="submit" value="Mettre à jour le livre.">
    </form>
    <p><a href="index.php" class="edit-book">Retour à la liste des livres</a></p>
  </main>
</body>
</html>