<?php
require 'config.php';

class ProductDAO
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProducts()
    {
        $query = "SELECT p.idProduct, p.reference, p.description, p.priceTaxExcl, p.priceTaxIncl, p.quantity, l.digit_iso, l.taxRate FROM product AS p INNER JOIN language as l ON langId = l.idLang";
        $result = $this->db->query($query);

        if (!$result) {
            die("Erreur dans la requête : " . $this->db->error);
        }

        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }

    public function getAllTaxRate()
    {
        $query = "SELECT * FROM language";
        $result = $this->db->query($query);

        if (!$result) {
            die("Erreur dans la requête : " . $this->db->error);
        }

        $langs = $result->fetch_all(MYSQLI_ASSOC);
        return $langs;
    }

    public function getTaxRateById($langId)
    {
        $query = "SELECT taxRate FROM language WHERE idLang = '$langId'";
        $result = $this->db->query($query);

        if (!$result) {
            die("Erreur dans la requête : " . $this->db->error);
        }

        $taxRate = $result->fetch_assoc();
        return $taxRate;
    }

    public function getProductById($productId) {
        $productQuery = "SELECT * FROM product WHERE idProduct = '$productId'";
            $result = $this->db->query($query);

            if (!$result) {
                die("Erreur dans la requête : " . $this->db->error);
            }

            $productTax = $result->fetch_assoc();
            return $productTax;
    }

    
    public function addTaxToProduct($currProductId, $langId) {
        $taxRate = $this->getTaxRateById($langId);
        
        $query = "UPDATE product
        SET priceTaxIncl = priceTaxExcl * (1 + (SELECT taxRate FROM language WHERE idLang = '$langId') / 100),
            priceTaxExcl = priceTaxExcl
        WHERE idProduct = '$currProductId'";

        $result = $this->db->query($query);
        if (!$result) {
            die("Erreur dans la requête : " . $this->db->error);
        }
        return $result;
    }
    
    public function createProduct($reference, $description, $priceTaxExcl, $quantity, $langId) 
    {
        $query = "INSERT INTO product (reference, description, priceTaxExcl, quantity, langId) VALUES ('$reference', '$description', '$priceTaxExcl', '$quantity', $langId)";
        
        $result = $this->db->query($query);
        if (!$result) {
            die("Erreur lors de la creation du produit : " . $this->db->error);
            header('Content-Type: application/json');
            echo json_encode(["message" => "Erreur lors de la creation du produit"]);
        }

        // Ajout de la taxe sur le produit
        $currProductId = $this->db->insert_id;
        $taxResponse = $this->addTaxToProduct($currProductId, $langId);

        if (!$taxResponse) {
            die("Erreur lors du calcul de la taxe du produit : " . $this->db->error);
            header('Content-Type: application/json');
            echo json_encode(["message" => "Erreur lors du calcul de la taxe du produit"]);
        }

        header('Content-Type: application/json');
        echo json_encode(["message" => "Produit crée"]);
        
    }

    public function editProduct($productId ,$reference, $description, $priceTaxExcl, $quantity, $langId) {

        $query = "UPDATE product 
        SET reference = COALESCE(NULLIF('$reference', ''), reference), 
            description = COALESCE(NULLIF('$description', ''), description),
            priceTaxExcl = COALESCE(NULLIF('$priceTaxExcl', ''), priceTaxExcl),
            quantity = COALESCE(NULLIF('$quantity', ''), quantity),
            langId = COALESCE(NULLIF('$langId', ''), langId)
        WHERE idProduct = '$productId'";

         $result = $this->db->query($query);
         if (!$result) {
             die("Erreur dans la requête : " . $this->db->error);
         }
            if ($priceTaxExcl) {
                $taxResponse = $this->addTaxToProduct($productId, $langId);
                if (!$taxResponse) {
                    die("Erreur lors du calcul de la taxe du produit : " . $this->db->error);
                    header('Content-Type: application/json');
                    echo json_encode(["message" => "Erreur lors du calcul de la taxe du produit"]);
                }
            }


         header('Content-Type: application/json');
         echo json_encode(["message" => "Produit mis à jour!"]);
    }

    public function deleteProduct($productId)
    {
        $query = "DELETE FROM product WHERE idProduct = '$productId'";
        $result = $this->db->query($query);

        // Vérifier si la requête de suppression a réussi
        if (!$result) {
            die("Erreur lors de la suppression du produit : " . $this->db->error);
        }
    }
}

?>