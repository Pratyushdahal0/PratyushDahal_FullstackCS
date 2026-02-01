function addToCart(itemId){
    const qtyInput = document.getElementById('qty_' + itemId);
    const quantity = parseInt(qtyInput.value) || 1;

    const formData = new FormData();
    formData.append('item_id', itemId);
    formData.append('quantity', quantity);

    fetch('../ajax/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('cartCount').textContent = data.totalQty;
    })
    .catch(err => console.error(err));
}
