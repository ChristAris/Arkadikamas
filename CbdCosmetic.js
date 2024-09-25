// variables
const cartBtn = document.querySelector(".cart-btn");
const closeCartBtn = document.querySelector(".close-cart");
const clearCartBtn = document.querySelector(".clear-cart");
const cartDOM = document.querySelector(".cart");
const cartOverlay = document.querySelector(".cart-overlay");
const cartItems = document.querySelector(".cart-items");
const cartTotal = document.querySelector(".cart-total"); 
const cartContent = document.querySelector(".cart-content");
const productsDOM = document.querySelector(".products-center");
const btns = document.querySelectorAll(".bag-btn");

//cart
let cart = [];
let favorites = [];
//buttons
let buttonsDOM= [];
let favoriteButtonsDOM = [];

//getting the products
class Products {
    async getProducts() {
        try {
            let result = await fetch('CbdCosmetics.json');
            let data = await result.json();
            let products = data.items;
            products = products.map(item => {
                const { title, price } = item.fields;
                const { id } = item.sys;
                const image = item.fields.image.fields.file.url;
                return { title, price, id, image };
            });
            return products;
        } catch (error) {
            console.log(error);
        }
    }
    

}
// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
async function checkLoginStatus() {
    try {
        let response = await fetch('actions/login.php?check_login=1');
        let data = await response.json();
        return data.loggedIn;
    } catch (error) {
        console.error("Error checking login status:", error);
        return false;
    }
}

async function exportData() {
    const client = new window.mongodb.MongoClient('mongodb+srv://<username>:<password>@<cluster>.mongodb.net/<database>');

    try {
        await client.connect();
        const database = client.db('myDB');
        const collection = database.collection('ratings');

        const data = await collection.find({}).toArray();
        const jsonData = JSON.stringify(data, null, 2);

        // Δημιουργούμε ένα αντικείμενο Blob με τα δεδομένα JSON
        const blob = new Blob([jsonData], { type: 'application/json' });

        // Δημιουργούμε ένα σύνδεσμο για το αρχείο JSON
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'myDB.rating.json';
        a.click();

        console.log('Τα δεδομένα εξάχθηκαν με επιτυχία!');
    } catch (error) {
        console.error('Σφάλμα κατά την εξαγωγή των δεδομένων:', error);
    } finally {
        await client.close();
    }
} 





function getIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}



async function loadRatings(productId) {
    try {
        let result = await fetch('myDB.rating.json');
        let data = await result.json();
        
        let productRatings = data.filter(item => item.ratings.some(rating => rating.product_id === productId));
        
        displayRatings(productRatings);
    } catch (error) {
        console.error("Error loading ratings:", error);
    }
}
// Συνάρτηση που μετατρέπει έναν αριθμό σε συμβολοσειριακό πίνακα αστεριών
function convertToStars(number) {
    let stars = '';
    for (let i = 0; i < number; i++) {
        stars += '⭐'; // Εδώ μπορείτε να χρησιμοποιήσετε οποιοδήποτε σύμβολο αστέρι θέλετε
    }
    return stars;
}



function displayRatings(productRatings) {
    const ratingsContainer = document.getElementById('ratings-container');
    
    if (productRatings.length === 0) {
        const noRatingsMessage = document.createElement('p');
        noRatingsMessage.textContent = 'Δεν υπάρχουν αξιολογήσεις για αυτό το προϊόν ακόμα.🗽';
        ratingsContainer.appendChild(noRatingsMessage);
    } else {
        productRatings.forEach(item => {
            item.ratings.forEach(rating => {
                const ratingDiv = document.createElement('div');
                ratingDiv.classList.add('rating');
                ratingDiv.innerHTML = `
                    <p>Βαθμολογία: ${convertToStars(rating.rating)}</p>
                    <p>Σχόλιο: ${rating.comment}</p>



                `;
                ratingsContainer.appendChild(ratingDiv);
            });
        });
    }
}



function loadProducts(productId) {
    const savedProducts = localStorage.getItem('products');
    if (!savedProducts) {
        console.error('No products found in localStorage');
        return;
    }
    const products = JSON.parse(savedProducts);

    // Έλεγχος εάν το productId υπάρχει στο localStorage
    const product = products.find(item => item.id === productId);
    if (!product) {
        console.error('Product not found in localStorage');
        return;
    }

    // Προβολή του προϊόντος στη σελίδα
    displayProduct(product);
}

function displayProduct(product) {
    const productContainer = document.getElementById('single-product-container');

    const productHTML = `
   <!--single product-->
            <article class="product">
                   <div class="single-product-container" 

                <div class="card5">
                    <div class="img-container">
                        <a href="product.php?id=${product.id}"> <!-- Προσθήκη του συνδέσμου -->
                            <img src=${product.image} alt="product" class="product-img"/>
                        </a>
                        <button class="bag-btn" data-id=${product.id}>
                            <i class="fas fa-shopping-cart"></i>
                            Προσθήκη στο καλάθι
                        </button>
                        <button class="favorite-btn" data-id=${product.id}>
                            <i class="fas fa-heart"></i>
                            Προσθήκη στα αγαπημένα
                        </button>
                    </div>
                    <h3>${product.title}</h3>
                    <h4>$${product.price}</h4>
             
                </div>
            </article></div>
            <!--end of single product-->
            `;
    productContainer.innerHTML = productHTML;


}


class UI {
    displayProducts(products) {
        let result = '';
        products.forEach(product => {
            result += `
        <!--single product-->
            <article class="product">
                <div class="card5">
                    <div class="img-container">
                        <a href="product.php?id=${product.id}"> <!-- Προσθήκη του συνδέσμου -->
                            <img src=${product.image} alt="product" class="product-img"/>
                        </a>
                  
                    </div>
                    <h3>${product.title}</h3>
                    <h4>$${product.price}</h4>
                         <div class="button-container">
                         <button class="bag-btn" data-id=${product.id}>
                            <i class="fas fa-shopping-cart"></i>
                            Προσθήκη στο καλάθι
                        </button>
                        <button class="favorite-btn" data-id=${product.id}>
                            <i class="fas fa-heart"></i>
                            Προσθήκη στα αγαπημένα
                        </button>
            
        </div>
             
                </div>
            </article>
            <!--end of single product-->
            `;
        });
        if (productsDOM) {
            productsDOM.innerHTML = result;
        }      
        this.getBagButtons();
        this.getFavoriteButtons();
           // Προσθήκη λειτουργικότητας αναζήτησης
           const searchInput = document.getElementById("search-item");

           searchInput.addEventListener("input", () => {
             const searchText = searchInput.value.toLowerCase();
             const products = document.querySelectorAll(".product");
             const noResultsMessage = document.getElementById("no-results-message");
             let foundResults = false;
             
             products.forEach(product => {
                 const title = product.querySelector("h3").innerText.toLowerCase();
                 if (title.includes(searchText)) {
                     product.style.display = "block";
                     foundResults = true;
                 } else {
                     product.style.display = "none";
                 }
             });
         
             if (foundResults) {
                 noResultsMessage.style.display = "none";
             } else {
                 noResultsMessage.style.display = "block";
             }
         });
         
             }
             
    displayFavorites(favorites) {
        let favresult = '';
        favorites.forEach(favorite => {
            favresult += `
            <!--single product-->
            <article class="favorites">
            
                <div class="img-container">
                    <img src=${favorite.image} alt="favorite" class="favorite-img"/>
                    <button class="bag-btn" data-id=${favorite.id}>
                        <i class="fas fa-shopping-cart"></i>
                        Προσθήκη στο καλάθι
                    </button>
                    <button class="favorite1-btn" data-id=${favorite.id}>
                        Αφαίρεση από τα αγαπημένα
                    </button>
                </div>
                <h3>${favorite.title}</h3>
                <h4>$${favorite.price}</h4>
           
            </article>
            <!--end of single product-->
            `;
        });
        const favoritesContainer = document.querySelector(".favorites-container");
        if (favoritesContainer) {
            favoritesContainer.innerHTML = favresult;
            this.getFavorite1Buttons();
        }
    }
    
    

    getBagButtons() {
        const buttons = [...document.querySelectorAll(".bag-btn")];
        buttons.forEach(button => {
            button.addEventListener("click", async (event) => {
                event.stopPropagation();
                if (!button.disabled) {
                    button.disabled = true;
                    let id = button.dataset.id;
                    let inCartIndex = cart.findIndex(item => item.id === id);
                    if (inCartIndex !== -1) {
                        cart[inCartIndex].amount++;
                        Storage.saveCart(cart);
                        this.setCartValues(cart);
                        this.addCartItem(cart[inCartIndex]);
                        this.showCart();
                    } else {
                        let cartItem = { ...await Storage.getProduct(id), amount: 1 };
                        cart = [...cart, cartItem];
                        Storage.saveCart(cart);
                        this.setCartValues(cart);
                        this.addCartItem(cartItem);
                        this.showCart();
                    }
                }
            });
        });
    }

    async getFavoriteButtons() {
        const favoriteButtons = [...document.querySelectorAll(".favorite-btn")];
        const isLoggedIn = await checkLoginStatus();

        favoriteButtons.forEach(favoriteButton => {
            favoriteButton.addEventListener("click", async (event) => {
                event.stopPropagation();
                const loggedIn = await checkLoginStatus();
                if (!loggedIn) {
                    alert("Πρέπει να συνδεθείτε για να προσθέσετε στα αγαπημένα.");
                    return;
                }
                const button = event.target;
                const id = button.dataset.id;
                this.toggleFavorite(id, button);
            });
        });
    }

    async getFavorite1Buttons() {
        const favoriteButtons1 = [...document.querySelectorAll(".favorite1-btn")];
        const isLoggedIn = await checkLoginStatus();

        favoriteButtons1.forEach(favoriteButton1 => {
            favoriteButton1.addEventListener("click", async (event) => {
                event.stopPropagation();
                const loggedIn = await checkLoginStatus();
                if (!loggedIn) {
                    alert("Πρέπει να συνδεθείτε για να αφαιρέσετε από τα αγαπημένα.");
                    return;
                }
                const button = event.target;
                const id = button.dataset.id;
                this.removeFromFavorites(id, button, true);
            });
        });
    }

    addFavoriteItem(favoriteItem, favoritesDOM) {
        const div = document.createElement('div');
        div.classList.add('favorite-item');
        div.innerHTML = `<img src=${favoriteItem.image} alt="product">
            <div>
                <h4>${favoriteItem.title}</h4>
                <h5>$${favoriteItem.price}</h5>
                <span class="remove-item" data-id=${favoriteItem.id}>remove</span>
            </div>`;
        favoritesDOM.appendChild(div);
    }

    updateFavoritesCount() {
        const favoritesCount = favorites.length;
        document.querySelector(".heart-items").innerText = favoritesCount;
        localStorage.setItem("favoritesCount", favoritesCount);
    }

    updateFavoriteButton(button, isFavorite) {
        button.innerText = isFavorite ? "Αφαίρεση από τα αγαπημένα" : "Προσθήκη στα αγαπημένα";
    }

    setCartValues(cart) {
        let tempTotal = 0;
        cart.forEach(item => {
            tempTotal += item.price * item.amount;
        });
        cartTotal.innerText = parseFloat(tempTotal.toFixed(2));
        cartItems.innerText = cart.length; // Update this line to show the number of different products
    }

    addCartItem(item) {
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `<img src=${item.image} alt="product">
            <div>
                <h4>${item.title}</h4>
                <h5>$${item.price}</h5>
                <span class="remove-item" data-id=${item.id}>remove</span>
            </div>
            <div>
                <i class="fas fa-chevron-up" data-id=${item.id}></i>
                <p class="item-amount">${item.amount}</p>
                <i class="fas fa-chevron-down" data-id=${item.id}></i>
            </div>`;
        cartContent.appendChild(div);
    }

    showCart() {
        cartOverlay.classList.add('transparentBcg');
        cartDOM.classList.add('showCart');
    }

    setupApp() {
        cart = Storage.getCart();
        favorites = Storage.getFavorites();
        this.setCartValues(cart);
        this.populateCart(cart);
        this.displayFavorites(favorites);
        cartBtn.addEventListener('click', this.showCart);
        closeCartBtn.addEventListener('click', this.hideCart);
        this.setupCartFunctionality();

    }
    setupCartFunctionality() {
        const cartItems = document.querySelector(".cart-items");
        const cartContent = document.querySelector(".cart-content");
        const deleteCartBtn = document.querySelector(".clear-cart");
    
        // Ακροατής για το κουμπί διαγραφής καλαθιού
        deleteCartBtn.addEventListener("click", () => {
            this.clearCart(); // Καθαρίζει το καλάθι
            cartContent.innerHTML = ''; // Αδειάζει το περιεχόμενο του καλαθιού από το DOM
        });
    
    
        cartContent.addEventListener("click", event => {
            if (event.target.classList.contains("fa-chevron-up")) {
                const id = event.target.dataset.id;
                let item = cart.find(item => item.id === id);
                item.amount++;
                Storage.saveCart(cart);
                this.setCartValues(cart);
                event.target.parentElement.querySelector(".item-amount").innerText = item.amount;
            } else if (event.target.classList.contains("fa-chevron-down")) {
                const id = event.target.dataset.id;
                let item = cart.find(item => item.id === id);
                if (item.amount > 1) {
                    item.amount--;
                    Storage.saveCart(cart);
                    this.setCartValues(cart);
                    event.target.parentElement.querySelector(".item-amount").innerText = item.amount;
                } else {
                    this.removeFromCart(id);
                    cartContent.removeChild(event.target.parentElement.parentElement);
                }
            } else if (event.target.classList.contains("remove-item")) {
                const id = event.target.dataset.id;
                this.removeFromCart(id);
                cartContent.removeChild(event.target.parentElement.parentElement);
            }
        });
    }

    clearCart() {
        cart = [];
        Storage.saveCart(cart);
        this.setCartValues(cart);
    }

    removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        Storage.saveCart(cart);
        this.setCartValues(cart);
    }

    populateCart(cart) {
        cart.forEach(item => this.addCartItem(item));
    }

    hideCart() {
        cartOverlay.classList.remove('transparentBcg');
        cartDOM.classList.remove('showCart');
    }
    

    toggleFavorite(id, button) {
        const itemIndex = favorites.findIndex(item => item.id === id);
        const isFavorite = itemIndex !== -1;

        if (isFavorite) {
            favorites.splice(itemIndex, 1);
        } else {
            let favoriteItem = { ...Storage.getProduct(id) };
            favorites.push(favoriteItem);
        }

        Storage.saveFavorites(favorites);
        this.updateFavoritesCount();
        this.updateFavoriteButton(button, !isFavorite);
    }

    removeFromFavorites(id, button, isFavPage) {
        favorites = favorites.filter(item => item.id !== id);
        Storage.saveFavorites(favorites);
        this.updateFavoritesCount();
        this.updateFavoriteButton(button, false);
        if (isFavPage) {
            this.displayFavorites(favorites);
        }
    }
    
    
    
}


//local storage
class Storage {
    static saveProducts(products) {
        localStorage.setItem("products", JSON.stringify(products));
    }

    static getProduct(id) {
        let products = JSON.parse(localStorage.getItem('products'));
        return products.find(product => product.id === id);
    }

    static saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    static getCart() {
        return localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
    }

    static saveFavorites(favorites) {
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    static getFavorites() {
        return localStorage.getItem('favorites') ? JSON.parse(localStorage.getItem('favorites')) : [];
    }
}
// Εδώ είναι ο υπάρχον κώδικάς σας...

document.addEventListener("DOMContentLoaded", async () => {
    const ui = new UI();
    const products = new Products();
    ui.setupApp();

    const allProducts = await products.getProducts();
    ui.displayProducts(allProducts);
    Storage.saveProducts(allProducts);
    ui.getBagButtons();
    ui.getFavoriteButtons();
    if (window.location.pathname.endsWith('product.php')) {
        const productId = getIdFromUrl();
        loadProducts(productId);
        loadRatings(productId);

    }
    
    // Ελέγξτε αν η σελίδα είναι η Checkout.php και, αν ναι, εμφανίστε το καλάθι
    if (window.location.pathname.endsWith('Checkout.php')) {
        ui.showCart();
    }

    // Προσθήκη ακροατή για το κουμπί "Continue to Order"
    const continueToOrderButton = document.getElementById('continue_to_order');
    if (continueToOrderButton) {
        continueToOrderButton.addEventListener('click', (event) => {
            event.preventDefault(); // Αποτρέπει την ανακατεύθυνση αμέσως
            const cart = Storage.getCart();
            if (cart.length === 0) {
                alert('ΠΡΟΣΘΕΣΤΕ ΠΡΟΙΟΝΤΑ ΣΤΟ ΚΑΛΑΘΙ');
            } else {
                window.location.href = 'payment.php';
            }
        });
    }

    // Αν βρισκόμαστε στη σελίδα προϊόντων, φιλτράρουμε τα προϊόντα βάσει αναζήτησης
    if (window.location.pathname.endsWith('products.php')) {
        const searchParams = new URLSearchParams(window.location.search);
        const searchText = searchParams.get("search") ? searchParams.get("search").toLowerCase() : "";
        const noResultsMessage = document.getElementById("no-results-message");

        if (searchText) {
            const filteredProducts = allProducts.filter(product => product.title.toLowerCase().includes(searchText));
            ui.displayProducts(filteredProducts);
            if (filteredProducts.length === 0) {
                noResultsMessage.style.display = "block";
            } else {
                noResultsMessage.style.display = "none";
            }
        } else {
            ui.displayProducts(allProducts);
            noResultsMessage.style.display = "none";
        }
    }
});


