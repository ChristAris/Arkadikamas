document.addEventListener('DOMContentLoaded', function() {
    const productId = getIdFromUrl(); // Υποθέτοντας ότι έχετε μια συνάρτηση για την ανάκτηση του ID από το URL
    loadProducts(productId);
});

function getIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id'); // Επιστροφή της τιμής του 'id'
}
function loadProducts(productId) {
    const savedProducts = localStorage.getItem('products');
    if (!savedProducts) {
        console.error('No products found in localStorage');
        return;
    }
    const products = JSON.parse(savedProducts);
    
    // Έλεγχος εάν το productId υπάρχει στο localStorage
    const product = products.find(item => item.sys.id === productId);
    if (!product) {
        console.error('Product not found in localStorage');
        return;
    }
    
    // Προβολή του προϊόντος στη σελίδα
    displayProduct(product);
}


function displayProduct(product) {
    const productContainer = document.getElementById('product-container');

    const productHTML = `
        <div class="product">
            <img src="${product.fields.image.fields.file.url}" alt="${product.fields.title}" class="product-img">
            <h2>${product.fields.title}</h2>
            <p>${product.fields.price}€</p>
        </div>
    `;

    productContainer.innerHTML = productHTML;
}