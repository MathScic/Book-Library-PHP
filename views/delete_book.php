<?php
require_once "../models/db.php";
require_once "../models/Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_POST['id'])) {
    $book->id = $_POST['id'];

    // Supprimer le livre de la base de données
    if ($book->delete()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "no_id";
}
?>