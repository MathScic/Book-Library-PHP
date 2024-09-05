<?php 
require_once '../models/Book.php';
require_once '../models/db.php';

//Connexion à la base de données 
$database = new Database();
$db = $database->getConnection();

//Initialisation de l'objet Book
$book = new Book($db);


// récupère tous les livres 
$stmt = $book-> readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion de la Bibliothèque</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <header>
    <h1>Listes des livres</h1>
  </header>
  <main>
    <table border="1">
      <tr>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Année</th>
        <th>Genre</th>
      </tr>
      <?php while ($row = $stmt-> fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
          <td><?php echo htmlspecialchars($row["title"]); ?></td>
          <td><?php echo htmlspecialchars($row["author"]); ?></td>
          <td><?php echo htmlspecialchars($row["year"]); ?></td>
          <td><?php echo htmlspecialchars($row["genre"]); ?></td>
        </tr>
      <?php endwhile ?>
    </table>
    <p><a href="add_book.php" id="main-page">Ajoutons des livres</a></p>
    <p><a href="edit_book.php" id="edit-page">Modifions des livres</a></p>
  </main>
</body>
</html>