<?php
require_once '../models/db.php';
require_once '../models/Book.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialisation de l'objet Book
$book = new Book($db);

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->year = $_POST['year'];
    $book->genre = $_POST['genre'];

    // Ajouter le livre dans la base de données
    if ($book->create()) {
        echo "<p>Livre ajouté avec succès !</p>";
    } else {
        echo "<p>Erreur lors de l'ajout du livre.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="../assets/add_book.css">
</head>
<body>
    <header>
        <h1>Ajouter un Nouveau Livre</h1>
    </header>
    <main>
        <form method="POST" action="add_book.php">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" required><br>

            <label for="author">Auteur :</label>
            <input type="text" name="author" id="author" required><br>

            <label for="year">Année :</label>
            <input type="number" name="year" id="year" required><br>

            <label for="genre">Genre :</label>
            <input type="text" name="genre" id="genre" required><br>

            <input type="submit" value="Ajouter le Livre">
        </form>
        <p><a href="index.php" id="add-book">Retour à la liste des livres</a></p>
    </main>
</body>
</html>

