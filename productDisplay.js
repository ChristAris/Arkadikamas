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

class Products {
    async getProducts() {
        try {
            let result = await fetch('products.json');
            let data = await result.json();
            let products = [];

            data.forEach(category => {
                category.items.forEach(item => {
                    const { title, price, image, syst } = item.fields; // Προσθήκη του syst
                    const id = item.sys ? item.sys.id : null;
                    if (id) {
                        const imageUrl = image ? image.fields.file.url : null;
                        products.push({ id, title, price, image: imageUrl, syst }); // Προσθήκη του syst στο αντικείμενο
                    }
                });
            });

            return products;
        } catch (error) {
            console.log(error);
            return [];
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
    const uri = 'mongodb+srv://<username>:<password>@<cluster>.mongodb.net/<database>';
    const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

    try {
        await client.connect();
        const database = client.db('myDB');
        const collection = database.collection('ratings');

        const data = await collection.find({}).toArray();
        const jsonData = JSON.stringify(data, null, 2);

        // Γράφουμε τα δεδομένα σε ένα αρχείο JSON
        const filePath = path.join(__dirname, '/../myDB.rating.json');
        fs.writeFileSync(filePath, jsonData, 'utf8');

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
        let result = await fetch('myDB.rating.json'); // Βεβαιώσου ότι αυτό είναι το σωστό μονοπάτι
        let data = await result.json();
        
        console.log("Fetched Data: ", data); // Εκτύπωση των δεδομένων για έλεγχο

        let productRatings = data.filter(item => 
            item.ratings.some(rating => rating.product_id === productId)
        );
        
        console.log("Filtered Product Ratings: ", productRatings); // Εκτύπωση των φιλτραρισμένων αξιολογήσεων

        displayRatings(productId,productRatings);
    } catch (error) {
        console.error("Error loading ratings:", error);
    }
}


// Convert number to star string
function convertToStars(number) {
    let stars = '';
    for (let i = 0; i < number; i++) {
        stars += '⭐';
    }
    return stars;
}

function displayRatings(productId,productRatings) {
    const ratingsContainer = document.getElementById('ratings-container');
    
    if (!ratingsContainer) {
        console.error("Ratings container not found");
        return;
    }

    ratingsContainer.innerHTML = ''; // Καθαρισμός των υπαρχόντων αξιολογήσεων

    if (productRatings.length === 0) {
        const noRatingsMessage = document.createElement('p');
        noRatingsMessage.textContent = 'Δεν υπάρχουν αξιολογήσεις για αυτό το προϊόν ακόμα.🗽';
        ratingsContainer.appendChild(noRatingsMessage);
    } else {
        productRatings.forEach(item => {
            item.ratings.forEach(rating => {
                if (rating.product_id === productId) {
                    const ratingDiv = document.createElement('div');
                    ratingDiv.classList.add('rating');
                    ratingDiv.innerHTML = `
                        <p>Βαθμολογία: ${convertToStars(parseInt(rating.rating))}</p>
                        <p>Σχόλιο: ${rating.comment}</p>
                    `;
                    ratingsContainer.appendChild(ratingDiv);
                }
            });
        });
    }
}


function setupSearchFunctionality() {
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
    const ingredientsContainer = document.getElementById('product-ingredients'); // Στοχεύουμε το στοιχείο συστατικών

    // Αν το πεδίο 'syst' υπάρχει, διαφορετικά κενή τιμή
    const ingredients = product.syst ? product.syst : 'Δεν υπάρχουν διαθέσιμα συστατικά';

    // Δημιουργία του HTML περιεχομένου
    const productHTML = `
        <article class="product-new">
            <div class="card-larger">
                <div class="img-container-larger">
                        <img src="${product.image}" alt="item" class="item-img-larger"/>
                    
                </div>
                <h3 class="item-title">${product.title}</h3>
                <h4 class="item-price">$${product.price}</h4>
                <div class="button-container-new">
                    <button class="bag-btn" data-id="${product.id}">
                        <i class="fas fa-shopping-cart"></i>
                        Προσθήκη στο καλάθι
                    </button>
                    <button class="favorite-btn" data-id="${product.id}">
                        <i class="fas fa-heart"></i>
                        Προσθήκη στα αγαπημένα
                    </button>
                </div>
               
            </div>
        </article>
    `;
    
    // Ενημέρωση του HTML περιεχομένου
    productContainer.innerHTML = productHTML;
    ingredientsContainer.textContent = ingredients; // Ενημερώνουμε τα συστατικά στο άλλο πεδίο
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
                const nonEmptyFavorites = favorites.filter(fav => Object.keys(fav).length > 0);  // Αφαιρεί τα κενά αντικείμενα
                nonEmptyFavorites.forEach(favorite => {
                    favresult += `
                    <article class="product">
                        <div class="card5">
                            <div class="img-container">
                                <a href="product.php?id=${favorite.id}">
                                    <img src=${favorite.image} alt="product" class="product-img"/>
                                </a>
                            </div>
                            <h3>${favorite.title}</h3>
                            <h4>$${favorite.price}</h4>
                            <div class="button-container">
                                <button class="bag-btn" data-id=${favorite.id}>
                                    <i class="fas fa-shopping-cart"></i>
                                    Προσθήκη στο καλάθι
                                </button>
                                <button class="favorite-btn" data-id=${favorite.id}>
                                    <i class="fas fa-heart"></i>
                                    Αφαίρεση από τα αγαπημένα
                                </button>
                            </div>
                        </div>
                    </article>
                    `;
                });
            
                const favoritesContainer = document.querySelector(".favorites-container");
                if (favoritesContainer) {
                    favoritesContainer.innerHTML = favresult;
                    this.getFavorite1Buttons();
                }
            }
    
    

    // Διασφάλιση σωστής λειτουργίας της προσθήκης στο καλάθι
    async getBagButtons() {
        const buttons = [...document.querySelectorAll(".bag-btn")];
        
        buttons.forEach(button => {
            button.addEventListener("click", async (event) => {
                event.stopPropagation();
                let id = button.dataset.id;
                let inCart = cart.find(item => item.id === id);

                if (inCart) {
                    inCart.amount++;
                    this.updateCart(inCart);
                } else {
                    let product = await Storage.getProduct(id);
                    let cartItem = { ...product, amount: 1 };
                    cart = [...cart, cartItem];
                    this.addCartItem(cartItem);
                    this.setCartValues(cart);
                }

                Storage.saveCart(cart);
                this.showCart();
            });
        });
        
    }
    updateCart(item) {
        const cartItems = [...cartContent.children];
        cartItems.forEach(cartItem => {
            if (cartItem.querySelector(".remove-item").dataset.id === item.id) {
                cartItem.querySelector(".item-amount").innerText = item.amount;
            }
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
        // Φόρτωση των αγαπημένων από το Local Storage
        const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
    
        // Αριθμός αγαπημένων
        const favoritesCount = favorites.length;
    
        // Ενημέρωση του στοιχείου στο navbar
        document.querySelector(".heart-items").innerText = favoritesCount;
    
        // Αποθήκευση του favoritesCount στο Local Storage (προαιρετικό)
        localStorage.setItem("favoritesCount", favoritesCount);
    }

    updateFavoriteButton(button, isFavorite) {
        button.innerText = isFavorite ? "Αφαίρεση από τα αγαπημένα" : "Προσθήκη στα αγαπημένα";
        button.classList.toggle("active", isFavorite);  // Ενημέρωση οπτικής κατάστασης

    }
    setCartValues(cart) {
        let tempTotal = 0;  // Για το συνολικό ποσό
        let itemsTotal = 0; // Για το σύνολο των προϊόντων (ποσότητες)
    
        cart.forEach(item => {
            const price = parseFloat(item.price);  // Μετατρέπουμε την τιμή σε αριθμό
            const amount = parseInt(item.amount);  // Μετατρέπουμε την ποσότητα σε αριθμό
            tempTotal += price * amount;  // Προσθέτουμε το ποσό για κάθε προϊόν
            itemsTotal += amount;  // Προσθέτουμε τις ποσότητες
        });
    
        cartTotal.innerText = `${tempTotal.toFixed(2)}`;  // Εμφανίζουμε το συνολικό ποσό με 2 δεκαδικά
        cartItems.innerText = itemsTotal;  // Εμφανίζουμε το σύνολο των προϊόντων (ποσότητες)
    }
    
   
    addCartItem(item) {
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
            <img src=${item.image} alt="product">
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
                event.target.nextElementSibling.innerText = item.amount; // Ενημερώνουμε την ποσότητα
            } else if (event.target.classList.contains("fa-chevron-down")) {
                const id = event.target.dataset.id;
                let item = cart.find(item => item.id === id);
                if (item.amount > 1) {
                    item.amount--;
                    Storage.saveCart(cart);
                    this.setCartValues(cart);
                    event.target.previousElementSibling.innerText = item.amount; // Ενημερώνουμε την ποσότητα
                } else {
                    this.removeFromCart(id);
                    cartContent.removeChild(event.target.parentElement.parentElement); // Αφαιρούμε το προϊόν από το DOM
                }
            } else if (event.target.classList.contains("remove-item")) {
                const id = event.target.dataset.id;
                this.removeFromCart(id);
                cartContent.removeChild(event.target.parentElement.parentElement); // Αφαιρούμε το προϊόν από το DOM
            }
        });
    }

    clearCart() {
        cart = [];
        Storage.saveCart(cart);
        this.setCartValues(cart);
        while (cartContent.children.length > 0) {
            cartContent.removeChild(cartContent.children[0]);
        }
    }
    
    removeFromCart(id) {
        cart = cart.filter(item => item.id !== id); // Αφαιρούμε το προϊόν από το καλάθι
        this.setCartValues(cart); // Ενημερώνουμε τις τιμές στο καλάθι
        Storage.saveCart(cart); // Αποθηκεύουμε τις αλλαγές στο localStorage
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
        this.updateFavoritesCount();  // Ενημέρωση των αγαπημένων μετά την αφαίρεση

        this.updateFavoriteButton(button, false);
        if (isFavPage) {
            this.displayFavorites(favorites);
        }
        else {
            // Βρες και αφαίρεσε το στοιχείο του προϊόντος από το DOM
            const productElement = document.querySelector(`.product .favorite-btn[data-id="${id}"]`).closest(".product");
            if (productElement) {
                productElement.remove();
            }
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
        const nonEmptyFavorites = favorites.filter(fav => Object.keys(fav).length > 0);  // Φιλτράρει τα κενά αντικείμενα
        localStorage.setItem('favorites', JSON.stringify(nonEmptyFavorites));
    }

    static getFavorites() {
        let favorites = localStorage.getItem('favorites') ? JSON.parse(localStorage.getItem('favorites')) : [];
        return favorites.filter(fav => Object.keys(fav).length > 0);  // Αφαιρεί τα κενά αντικείμενα
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const ui = new UI();
    const products = new Products();
    ui.setupApp();

    const allProducts = await products.getProducts();
    Storage.saveProducts(allProducts);

    ui.displayProducts(allProducts);
    ui.updateFavoritesCount();  // Κλήση για ενημέρωση του favorites count


   // On product page load
   if (window.location.pathname.endsWith('product.php')) {
    const productId = getIdFromUrl();
    loadProducts(productId);
    loadRatings(productId);
    ui.getBagButtons(productId);
    ui.getFavoriteButtons(productId);
    
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


    
    setupSearchFunctionality();

});


