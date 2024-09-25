const client = contentful.createClient({
    // This is the space ID. A space is like a project folder in Contentful terms
    space: '53qrsk78viqd',
    // This is the access token for this space. Normally you get both ID and the token in the Contentful web app
    accessToken: '05NcT_EvyQH9vK7VE8yW_rQBdRRebMjVDbUZ_L1PCTM',
  });

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
//buttons
let buttonsDOM= [];
let favorites = [];


//getting the products
class Products{
   async getProducts(){
    try{
    let contentful = await client.getEntries({
       content_type: 'canacare'
    });
    
        
           
    // let result= await fetch('products.json');
    // let data = await result.json();
     let products = contentful.items;
     products = products.map(item=>{
      const {title,price} = item.fields;
      const {id} = item.sys;
      const image = item.fields.image.fields.file.url;
      return {title,price,id,image} 
     });
     return products
   }catch(error){
    console.log(error);

    } 
}
}
//display products
class UI{
  constructor() {
    // ... υπάρχουσες αρχικοποιήσεις

    this.favoriteDOM = document.querySelector(".favorite");
    this.favoriteOverlay = document.querySelector(".favorite-overlay");
    this.favoriteContent = document.querySelector(".favorite-content");
    this.favoriteBtn = document.querySelector(".heart-btn");
    this.favoriteItems = document.querySelector(".heart-items");

    this.setupFavorites();
    this.favoriteLogic();
  }
  setupFavorites() {
    favorites = StorageUtil.getFavorites(); // Αλλαγή εδώ
    this.setFavoriteValues(favorites);
    this.populateFavorites(favorites);
    this.favoriteBtn.addEventListener('click', () => this.showFavorites());
    document.querySelector(".close-favorite").addEventListener('click', () => this.hideFavorites());
  }


  setFavoriteValues(favorites) {
    this.favoriteItems.innerText = favorites.length;
  }

  populateFavorites(favorites) {
    favorites.forEach(item => this.addFavoriteItem(item));
  }


    displayProducts(products){
        let result='';
        products.forEach(product=>{
            result +=`
            <!--single product-->
            <article class="product">
              <div class="img-container">
                <img 
                src=${product.image}
                 alt="product"
                class="product-img"/>
                <button class="bag-btn" data-id=${product.id}>
                  <i class="fas fa-shopping-cart"></i>
                  Προσθηκη στο καλάθι
                </button>
                <button class="favorite-btn" data-id=${product.id}>
                 <i class="fas fa-heart"></i>
                 Προσθήκη στα Αγαπημένα
                </button>

              </div>
              <h3>${product.title}</h3>
              <h4>$${product.price}</h4>
            </article>
            <!--end of single product-->
            
            `;
        });
        productsDOM.innerHTML = result;

    }
    getBagButtons(){
        const buttons = [...document.querySelectorAll(".bag-btn")];
        buttonsDOM = buttons;
        buttons.forEach(button=>{
            let id = button.dataset.id;
            let inCart = cart.find(item => item.id === id);
            if(inCart){
                button.innerText = "Στο καλαθι";
                button.disabled= true;
            }
                  button.addEventListener("click",event=>{
                    event.target.innerText= "Στο καλαθι";
                    event.target.disabled = true;
                    //get product from products
                    let cartItem = {...Storage.getProduct(id), amount: 1 };
                    //add product to the cart
                    cart= [...cart,cartItem];
                    console.log(cart);
                    //save cart in local storage
                    Storage.saveCart(cart);
                    //set cart values
                    this.setCartValues(cart);
                    //display cart item
                    this.addCartItem(cartItem);
                    //show the cart
                    this.showCart();
                });
        });

    }
    setCartValues(cart){
        let tempTotal= 0;
        let itemsTotal = 0;
        cart.map(item=>{
            tempTotal += item.price * item.amount;
            itemsTotal += item.amount;
        })
        cartTotal.innerText = parseFloat(tempTotal.toFixed(2));
        cartItems.innerText = itemsTotal;
    }
    addCartItem(item){
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
    showCart(){
        cartOverlay.classList.add('transparentBcg');
        cartDOM.classList.add('showCart');

    }
    setupApp(){
        cart = StorageUtil.getCart();
        this.setCartValues(cart);
        this.populateCart(cart);
        cartBtn.addEventListener('click',this.showCart);
        closeCartBtn.addEventListener('click',this.hideCart);


    }
    populateCart(cart){
        cart.forEach(item=>this.addCartItem(item));
    }
    hideCart(){
        cartOverlay.classList.remove('transparentBcg');
        cartDOM.classList.remove('showCart');

    }
    cartLogic(){
        //clear cart button
        clearCartBtn.addEventListener('click',()=>{
            this.clearCart();
        });
        //cart functionality
        cartContent.addEventListener('click', event=>{
            if(event.target.classList.contains('remove-item'))
            {
                let removeItem = event.target;
                let id= removeItem.dataset.id;
                cartContent.removeChild(removeItem.parentElement.parentElement);
                this.removeItem(id);

            }
            else if(event.target.classList.contains('fa-chevron-up')){
                let addAmount= event.target;
                let id= addAmount.dataset.id;
                let tempItem = cart.find(item=> item.id ===id);
                tempItem.amount = tempItem.amount + 1;
                Storage.saveCart(cart);
                this.setCartValues(cart);
                addAmount.nextElementSibling.innerText = tempItem.amount;
            }
            else if(event.target.classList.contains('fa-chevron-down')){
                let lowerAmount = event.target;
                let id = lowerAmount.dataset.id;
                let tempItem = cart.find(item=> item.id ===id);
                tempItem.amount = tempItem.amount - 1;
                if(tempItem.amount > 0 ){
        Storage.saveCart(cart);
        this.setCartValues(cart);
        lowerAmount.previousElementSibling.innerText = tempItem.amount;

                }
                else{
                    cartContent.removeChild(lowerAmount.parentElement.parentElement);
                    this.removeItem(id);
                }

            }
        });
    }
    clearCart(){
        let cartItems = cart.map(item => item.id);
        cartItems.forEach(id => this.removeItem(id));
        console.log(cartContent.children);

        while(cartContent.children.length>0){
            cartContent.removeChild(cartContent.children[0])
        }
        this.hideCart();
    }
   removeItem(id){
    cart = cart.filter(item=> item.id !==id);
    this.setCartValues(cart);
    Storage.saveCart(cart);
    let button = this.getSingleButton(id);
    button.disabled = false;
    button.innerHTML = `<i class="fas fa-shopping-cart"></i>Προσθηκη στο καλαθι`;
    
   }
   getSingleButton(id){
    return buttonsDOM.find(button => button.dataset.id === id);
   }
   addFavoriteItem(item) {
    const div = document.createElement('div');
    div.classList.add('favorite-item');
    div.innerHTML = `<img src=${item.image} alt="product">
      <div>
        <h4>${item.title}</h4>
        <h5>$${item.price}</h5>
        <span class="remove-favorite-item" data-id=${item.id}>remove</span>
      </div>`;      
    favoriteContent.appendChild(div);
  }

  showFavorites() {
    favoriteOverlay.classList.add('transparentBcg');
    favoriteDOM.classList.add('showFavorites');
  }

  hideFavorites() {
    favoriteOverlay.classList.remove('transparentBcg');
    favoriteDOM.classList.remove('showFavorites');
  }

  favoriteLogic() {
    const favoriteContent = document.querySelector(".favorite-content"); // Προσθήκη αυτής της γραμμής
    favoriteContent.addEventListener('click', event => {
        if (event.target.classList.contains('remove-favorite-item')) {
            let removeItem = event.target;
            let id = removeItem.dataset.id;
            favoriteContent.removeChild(removeItem.parentElement.parentElement);
            this.removeFavoriteItem(id);
        }
    });
}

  removeFavoriteItem(id) {
    favorites = favorites.filter(item => item.id !== id);
    Storage.saveFavorites(favorites);
    let button = this.getFavoriteButton(id);
    button.innerHTML = `<i class="fas fa-heart"></i> Προσθήκη στα αγαπημένα`;
  }

  getFavoriteButton(id) {
    return buttonsDOM.find(button => button.dataset.id === id);
  }


}
class StorageUtil {
  static saveProducts(products) {
    localStorage.setItem("products", JSON.stringify(products));
  }

  static getProduct(id) {
    let products = JSON.parse(localStorage.getItem("products"));
    return products.find((product) => product.id === id);
  }

  static saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
  }

  static getCart() {
    return localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];
  }

  static saveFavorites(favorites) {
    localStorage.setItem("favorites", JSON.stringify(favorites));
  }

  static getFavorites() {
    return localStorage.getItem("favorites") ? JSON.parse(localStorage.getItem("favorites")) : [];
  }
}


document.addEventListener("DOMContentLoaded",()=>{
const ui = new UI();
const products = new Products();
//setup app
ui.setupApp();
//get all products
products.getProducts().then(products =>{
     ui.displayProducts(products);
     StorageUtil.saveProducts(products);
}).then(()=>{
 ui.getBagButtons();
 ui.cartLogic();
});

});

// Φορτώστε τα προϊόντα και περιμένετε να ολοκληρωθεί η φόρτωση
const products = new Products();
products.getProducts().then((data) => {
   // Εδώ τα δεδομένα έχουν φορτωθεί
   window.allProducts = data.slice(0); // Ορίστε τη μεταβλητή allProducts στο παγκόσμιο πεδίο
}).catch((error) => {
   console.error(error);
});
// Αναζήτηση προϊόντων
const searchInput = document.getElementById("search-item");
searchInput.addEventListener("keyup", () => {
  const searchText = searchInput.value.toLowerCase();
  const products = document.querySelectorAll(".product");
  const noResultsMessage = document.getElementById("no-results-message");

  let foundResults = false; // Αρχικά δεν βρέθηκαν αποτελέσματα

  products.forEach((product) => {
    const title = product.querySelector("h3").innerText.toLowerCase();
    if (title.includes(searchText)) {
      product.style.display = "block";
      foundResults = true; // Βρέθηκαν αποτελέσματα
    } else {
      product.style.display = "none";
    }
  });

  // Εμφάνιση/απόκρυψη του μηνύματος
  if (foundResults) {
    noResultsMessage.style.display = "none"; // Απόκρυψη του μηνύματος
  } else {
    noResultsMessage.style.display = "block"; // Εμφάνιση του μηνύματος
  }
});






