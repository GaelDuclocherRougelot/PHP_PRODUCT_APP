<?php
require 'product.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($data === null) {
        die("Erreur lors du décodage JSON.");
    }

    $reference = $data['reference'];
    $description = $data['description'];
    $priceTaxExcl = $data['priceTaxExcl'];
    $quantity = $data['quantity'];
    $langId = $data['langId'];

    $productDAO = new ProductDAO();
    $productDAO->createProduct($reference, $description, $priceTaxExcl, $quantity, $langId);

}
?>