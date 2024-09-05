<?php
class Book {
    private $conn;
    private $table_name = "books";

    public $id;
    public $title;
    public $author;
    public $year;
    public $genre;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire tous les livres
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY title";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Créer un nouveau livre
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (title, author, year, genre) VALUES (:title, :author, :year, :genre)";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->genre = htmlspecialchars(strip_tags($this->genre));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":genre", $this->genre);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Mettre à jour un livre existant
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET title = :title, author = :author, year = :year, genre = :genre WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Supprimer un livre
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind ID
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>