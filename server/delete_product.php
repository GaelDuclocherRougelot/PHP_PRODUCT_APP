<?php
require 'product.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (isset($data['idProduct'])) {
        // ID du produit à supprimer
        $productId = $data['idProduct'];

        // Supprimer le produit
        $productDAO = new ProductDAO();
        $productDAO->deleteProduct($productId);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Suppression réussie']);
    } else {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'ID du produit manquant']);
    }
}
?>