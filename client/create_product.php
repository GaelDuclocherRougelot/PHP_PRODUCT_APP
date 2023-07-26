<?php
require '../server/product.php';


$productDAO = new ProductDAO();
$langs = $productDAO->getAllTaxRate();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Créer un produit</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
  <header>
      <nav><a href="products.php">Produits</a></nav>
    </header>
    <main class="main__create__product">
      <h1>Ajouter un produit</h1>
      <form method="post" id="createForm">
        <input type="text" name="reference" placeholder="Référence" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" name="priceTaxExcl" min="1" step="any" placeholder="Prix HT" required>
        <input type="number" name="quantity" min="1" placeholder="Quantité" required>
        <select name="langId">
          <option value="">--Taxe--</option>
          <?php foreach ($langs as $lang): ?>
            <option value="<?php echo $lang['idLang']; ?>" name="langId"><?php echo $lang['digit_iso'] ?> <span><?php echo $lang['taxRate']; ?> %</span></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" id="create-button">Ajouter</button>
      </form>
    </main>
    <script src="./index.js"></script>
  </body>
</html>