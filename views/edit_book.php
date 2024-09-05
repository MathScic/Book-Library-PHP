<?php 
require_once "../models/db.php";
require_once "../models/Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Vérifier si l'ID du livre est passé dans l'URL
if (isset($_GET['id'])) {
    $book->id = $_GET['id'];

    // Récupérer les détails du livre dans la base de données
    $stmt = $db->prepare("SELECT * FROM books WHERE id = :id LIMIT 0,1");
    $stmt->bindParam(":id", $book->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Remplir les propriétés du livre avec les données récupérées
        $book->title = $row["title"];
        $book->author = $row["author"];
        $book->year = $row["year"];
        $book->genre = $row["genre"];
    } else {
        echo "<p>Livre non trouvé.</p>";
        exit;
    }

    // Vérifier si le formulaire a été soumis via la méthode POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mettre à jour les propriétés du livre avec les nouvelles données du formulaire
        $book->title = $_POST['title'];
        $book->author = $_POST['author'];
        $book->year = $_POST['year'];
        $book->genre = $_POST['genre'];

        // Mettre à jour le livre dans la base de données
        if ($book->update()) {
            echo "<p>Le livre a été mis à jour avec succès !</p>";
        } else {
            echo "<p>Erreur lors de la mise à jour du livre.</p>";
        }
    }
} else {
    echo "<p>Aucun livre sélectionné.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le livre</title>
    <link rel="stylesheet" href="../assets/edit_book.css">
</head>
<body>
    <header>
        <h1>Modifier le livre</h1>
    </header>
    <main>
        <form method="POST" action="edit_book.php?id=<?php echo $book->id; ?>">
            <label for="title">Titre :</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book->title); ?>" required><br>

            <label for="author">Auteur :</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($book->author); ?>" required><br>

            <label for="year">Année :</label>
            <input type="number" name="year" value="<?php echo htmlspecialchars($book->year); ?>" required><br>

            <label for="genre">Genre :</label>
            <input type="text" name="genre" value="<?php echo htmlspecialchars($book->genre); ?>" required><br>

            <input type="submit" value="Mettre à jour le livre">
        </form>
        <p><a href="index.php" id="edit-book">Retour à la liste des livres</a></p>
    </main>
</body>
</html>