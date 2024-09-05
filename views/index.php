<?php
require_once "../models/db.php";
require_once "../models/Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Récupérer tous les livres
$stmt = $db->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
    <link rel="stylesheet" href="../../library_management/assets/style.css">
</head>
<body>
    <header>
        <h1>Liste des livres</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Année</th>
                    <th>Genre</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['id']); ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['year']); ?></td>
                        <td><?php echo htmlspecialchars($book['genre']); ?></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>" id="edit-link">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="add_book.php">Ajouter un livre</a></p>
    </main>
</body>
</html>