<?php
include '../models/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Mettre à jour le livre
    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, year = ? WHERE id = ?");
    $stmt->execute([$title, $author, $year, $id]);

    // Redirection après la mise à jour
    header("Location: index.php");
    exit;
} else {
    echo "Méthode non autorisée.";
}
?>