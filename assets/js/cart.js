function addToCart(productName, productPrice) {
    // Retrieve the current cart data or set an empty array if nothing exists
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
    // Define the new product item
    const product = {
      name: productName,
      price: productPrice,
      quantity: 1
    };
  
    // Check if the product is already in the cart
    const existingProduct = cart.find(item => item.name === productName);
    if (existingProduct) {
      existingProduct.quantity += 1; // Increment quantity if the product is already in the cart
    } else {
      cart.push(product); // Add new product to the cart
    }
  
    // Save the updated cart back to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
  
    // Optional: Notify the user that the item has been added
    alert(`${productName} has been added to your cart!`);
  }
  