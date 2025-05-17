<!-- Product Card Component -->
<div class="product-card">
    <div class="product-link" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $product['product_id']; ?>">
        <div class="product-image position-relative" style="width: 100%; aspect-ratio: 1 / 1; background: #f8f9fa; border-radius: 1.4rem 1.4rem 0 0; overflow: hidden; display: flex; align-items: center; justify-content: center;">
            <img src="<?php echo htmlspecialchars(getProductImageUrl($product)); ?>"
                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                 class="img-fluid h-100 w-100"
                 style="object-fit: cover; border-radius: 1.4rem 1.4rem 0 0;"
                 onerror="this.src='uploads/products/default-product.jpg'">
        </div>
        <div class="product-info">
            <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
            <?php if (isset($product['category_name'])): ?>
                <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
            <?php endif; ?>
            <div class="product-price">₱<?php echo number_format($product['price'], 2); ?></div>
            <div class="product-stock <?php echo ($product['stock'] > 0) ? 'in-stock' : 'out-of-stock'; ?>">
                <?php echo ($product['stock'] > 0) ? 'In Stock' : 'Out of Stock'; ?>
            </div>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="modal fade" id="productModal<?php echo $product['product_id']; ?>" tabindex="-1" aria-labelledby="productModalLabel<?php echo $product['product_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        <div class="product-modal-image">
                            <img src="<?php echo htmlspecialchars(getProductImageUrl($product)); ?>"
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="img-fluid rounded-4"
                                 onerror="this.src='uploads/products/default-product.jpg'">
                        </div>
                    </div>
                    <!-- Product Details -->
                    <div class="col-md-6">
                        <div class="product-modal-details">
                            <h2 class="product-modal-title mb-3"><?php echo htmlspecialchars($product['name']); ?></h2>
                            <?php if (isset($product['category_name'])): ?>
                                <div class="product-modal-category mb-3"><?php echo htmlspecialchars($product['category_name']); ?></div>
                            <?php endif; ?>
                            <div class="product-modal-price mb-3">₱<?php echo number_format($product['price'], 2); ?></div>
                            <div class="product-modal-stock mb-4 <?php echo ($product['stock'] > 0) ? 'in-stock' : 'out-of-stock'; ?>">
                                <?php echo ($product['stock'] > 0) ? 'In Stock (' . $product['stock'] . ' available)' : 'Out of Stock'; ?>
                            </div>
                            <div class="product-modal-description mb-4">
                                <h5>Description</h5>
                                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            </div>
                            <?php if ($product['stock'] > 0): ?>
                                <form action="cart.php" method="post" class="add-to-cart-form mb-4">
                                    <div class="quantity-input mb-3">
                                        <label for="quantity<?php echo $product['product_id']; ?>" class="form-label">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity<?php echo $product['product_id']; ?>" 
                                               value="1" min="1" max="<?php echo $product['stock']; ?>" 
                                               class="form-control rounded-3" style="width: 100px;">
                                    </div>
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <input type="hidden" name="action" value="add">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">Add to Cart</button>
                                        <?php if (isLoggedIn()): ?>
                                            <button type="button" 
                                                    class="btn btn-outline-primary wishlist-toggle <?php echo isInWishlist($_SESSION['user_id'], $product['product_id']) ? 'in-wishlist' : ''; ?>"
                                                    data-product-id="<?php echo $product['product_id']; ?>"
                                                    title="Add to Wishlist">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <!-- Cart Toast -->
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="cartToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                Product added to cart successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
    <!-- Wishlist Toast -->
    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" id="wishlistToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-heart me-2"></i>
                <span id="wishlistToastMessage">Product added to wishlist!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<style>
.product-modal-image {
    width: 100%;
    aspect-ratio: 1;
    background: #f8f9fa;
    border-radius: 1rem;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-modal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-modal-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2c3e50;
}
.product-modal-category {
    color: #6c757d;
    font-size: 0.95rem;
}
.product-modal-price {
    font-size: 1.5rem;
    font-weight: 600;
    color: #4a90e2;
}
.product-modal-stock {
    font-size: 0.95rem;
    font-weight: 500;
}
.product-modal-stock.in-stock {
    color: #28a745;
}
.product-modal-stock.out-of-stock {
    color: #dc3545;
}
.product-modal-description h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}
.product-modal-description p {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 0;
}
.wishlist-toggle.in-wishlist {
    color: #dc3545;
    border-color: #dc3545;
}
.wishlist-toggle.in-wishlist:hover {
    background-color: #dc3545;
    color: white;
}

/* Toast Styles */
.toast {
    min-width: 300px;
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.toast.bg-success {
    background-color: #28a745 !important;
}
.toast.bg-primary {
    background-color: #4a90e2 !important;
}
.toast-body {
    font-size: 0.95rem;
    font-weight: 500;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize toasts
    const cartToast = new bootstrap.Toast(document.getElementById('cartToast'));
    const wishlistToast = new bootstrap.Toast(document.getElementById('wishlistToast'));
    
    // Handle cart form submission
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const quantity = formData.get('quantity');
            
            // Validate quantity
            if (quantity < 1) {
                alert('Please enter a valid quantity');
                return;
            }
            
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in header
                    const cartBadge = document.querySelector('.cart-badge');
                    if (cartBadge) {
                        const currentCount = parseInt(cartBadge.textContent) || 0;
                        cartBadge.textContent = currentCount + parseInt(quantity);
                    }
                    
                    // Show success toast
                    cartToast.show();
                    
                    // Close modal if it's open
                    const modal = bootstrap.Modal.getInstance(document.querySelector('.modal.show'));
                    if (modal) {
                        modal.hide();
                    }
                } else {
                    // Show error message
                    alert(data.message || 'Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart');
            });
        });
    });
    
    // Handle add to cart from wishlist
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantity = 1; // Default quantity for wishlist items
            
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `action=add&product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in header
                    const cartBadge = document.querySelector('.cart-badge');
                    if (cartBadge) {
                        const currentCount = parseInt(cartBadge.textContent) || 0;
                        cartBadge.textContent = currentCount + quantity;
                    }
                    alert('Product added to cart successfully!');
                } else {
                    alert(data.message || 'Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart');
            });
        });
    });
    
    // Handle wishlist toggle
    document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            const isInWishlist = this.classList.contains('in-wishlist');
            const toastMessage = document.getElementById('wishlistToastMessage');
            
            fetch('wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `action=${isInWishlist ? 'remove' : 'add'}&product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update wishlist button state
                    this.classList.toggle('in-wishlist');
                    // Update all wishlist buttons for this product
                    document.querySelectorAll(`.wishlist-toggle[data-product-id="${productId}"]`).forEach(btn => {
                        btn.classList.toggle('in-wishlist');
                    });
                    
                    // Show appropriate toast message
                    toastMessage.textContent = isInWishlist ? 
                        'Product removed from wishlist!' : 
                        'Product added to wishlist!';
                    wishlistToast.show();
                } else {
                    // If the product is already in wishlist, update the UI to reflect that
                    if (data.message === 'Product is already in your wishlist') {
                        this.classList.add('in-wishlist');
                        document.querySelectorAll(`.wishlist-toggle[data-product-id="${productId}"]`).forEach(btn => {
                            btn.classList.add('in-wishlist');
                        });
                    }
                    // Show error message
                    toastMessage.textContent = data.message;
                    wishlistToast.show();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastMessage.textContent = 'An error occurred while updating the wishlist';
                wishlistToast.show();
            });
        });
    });
});
</script>
