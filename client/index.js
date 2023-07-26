function deleteProduct(productId) {
  // Envoyer une requête AJAX pour supprimer le produit
  fetch("../server/delete_product.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ idProduct: productId }),
  })
    .then((response) => response.json())
    .then((data) => {
      location.reload();
    })
    .catch((error) =>
      console.error("Erreur lors de la suppression du produit :", error)
    );
}

function createProduct(e) {
  e.preventDefault();

  const formData = new FormData(createForm);

  const data = Object.fromEntries(formData.entries());

  fetch("../server/create_product.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      location.replace("./products.php");
    })
    .catch((error) =>
      console.error("Erreur lors de la creation du produit :", error)
    );
}

function editProduct(e, productId, editForm) {
  e.preventDefault();

  const formData = new FormData(editForm);

  let data = Object.fromEntries(formData.entries());
  data.productId = productId;

  fetch("../server/edit_product.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      location.reload();
    })
    .catch((error) =>
      console.error("Erreur lors de la mise à jour du produit :", error)
    );
}

function ready() {
  const deleteButtons = document.querySelectorAll(".delete-button");
  const createForm = document.getElementById("createForm");
  const productCards = document.querySelectorAll(".product__card");

  // Delete buttons actions
  deleteButtons.forEach((button) => {
    const productId = button.dataset.productId;
    button.addEventListener("click", () => {
      deleteProduct(productId);
    });
  });

  // Cards actions
  productCards.forEach((card) => {
    const productId = card.dataset.productId;
    const editForm = card.querySelector(".edit-product-form");

    editForm.addEventListener("submit", (e) =>
      editProduct(e, productId, editForm)
    );
  });

  // Create button actions
  if (
    window.location.pathname === "/PHP_PRODUCT_APP/client/create_product.php"
  ) {
    createForm.addEventListener("submit", (e) => createProduct(e));
  }
}

document.addEventListener("DOMContentLoaded", ready);
