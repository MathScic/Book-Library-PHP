<?php
require_once "../models/db.php";
require_once "../models/Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Récupérer les livres
$query = "SELECT * FROM books";
$stmt = $db->prepare($query);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <h1>Liste des livres</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Année</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr data-id="<?php echo $row['id']; ?>">
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td><?php echo htmlspecialchars($row['genre']); ?></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="modif-link">Modifier</a>
                            <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>); return false;" class="delete-link">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <script>
    function confirmDelete(bookId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_book.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        document.querySelector(`tr[data-id="${bookId}"]`).remove();
                        alert('Le livre a été supprimé avec succès.');
                    } else {
                        alert('Erreur lors de la suppression du livre.');
                    }
                } else {
                    alert('Erreur lors de la suppression du livre.');
                }
            };
            
            xhr.send(`id=${bookId}`);
        }
    }
    </script>
</body>
</html>