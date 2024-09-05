<?php 
require_once 'models/db.php'; 

$database = new Database();
$db = $database->getConnection(); 

if($db) {
  echo "Connexion réussie à la base de données !";
} else {
  echo "Echec de connexion à la base de données.";
}
?>
