<?php
require '../server/product.php';


$productDAO = new ProductDAO();
$products = $productDAO->getProducts();
$langs = $productDAO->getAllTaxRate();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Products</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <header>
      <nav><a href="create_product.php">Ajouter un produit</a></nav>
    </header>
    <main>
      <?php foreach ($products as $product): ?>
            <div class="product__card" data-product-id="<?php echo $product['idProduct']; ?>">
            <div>
              <h2><?php echo $product['reference']; ?></h2>
              <p class="description"><?php echo $product['description']; ?></p>
              <p>Prix HT: <?php echo $product['priceTaxExcl']; ?> €</p>
              <p>Prix TTC: <?php echo $product['priceTaxIncl']; ?> €</p>
              <p>Quantité: <?php echo $product['quantity']; ?></p>
                <button class="delete-button" data-product-id="<?php echo $product['idProduct']; ?>">Supprimer</button>

            </div>
    
                <form method="post" class="edit-product-form">
                  <input type="text" name="reference" placeholder="Référence">
                  <input type="text" name="description" placeholder="Description">
                  <input type="number" name="priceTaxExcl" min="1" step="any" placeholder="Prix HT">
                  <input type="number" name="quantity" min="1" placeholder="Quantité">

                  <select name="langId">
                    <option value="">--Taxe--</option>
                    <?php foreach ($langs as $lang): ?>
                      <option value="<?php echo $lang['idLang']; ?>" name="langId"><?php echo $lang['digit_iso'] ?> <span><?php echo $lang['taxRate']; ?> %</span></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit">Sauvgrader</button>
                </form>
            </div>
        <?php endforeach; ?>
    </main>
    <script src="./index.js"></script>
  </body>
</html>
