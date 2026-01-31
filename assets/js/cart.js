function addToCart(id) {
  fetch("../ajax/cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ item_id: id })
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById("cartCount").innerText = data.count;
  });
}