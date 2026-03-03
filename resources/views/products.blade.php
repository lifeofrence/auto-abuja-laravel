@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('public/img/carousel-bg-2.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Products</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Products Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Search Section -->
            <div class="row mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-lg-12">
                    <div class="bg-light p-4 rounded">
                        <form method="GET" action="{{ url('/product') }}" class="row g-3 align-items-center">
                            <!-- Search Bar -->
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search for products (e.g., Benz, Camry, EV)..." value="{{ $search }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>

                            <!-- Wishlist and Cart -->
                            <div class="col-lg-6 text-end">
                                <button type="button" class="btn btn-outline-danger me-2" id="wishlistBtn">
                                    <i class="fa fa-heart"></i> Wishlist (<span id="wishlistCount">0</span>)
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="cartBtn">
                                    <i class="fa fa-shopping-cart"></i> Cart (<span id="cartCount">0</span>)
                                </button>
                            </div>
                        </form>

                        <!-- Results Count -->
                        <div class="mt-3">
                            <p class="mb-0 text-muted">
                                <i class="fa fa-info-circle me-2"></i>
                                Showing <span>{{ $products->total() }}</span> product(s)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4" id="productsGrid">
                @forelse($products as $product)
                    <div class="col-lg-3 col-md-6 wow fadeInUp product-item" data-wow-delay="0.1s">
                        <div class="card h-100 border-0 shadow">
                            <div class="position-relative">
                                <!-- In a real app we'd load the product image; fallback to placeholder here -->
                                <img src="{{ asset('public/img/bg-intro.jpg') }}" class="card-img-top" alt="{{ $product->name }}"
                                    style="height:200px; object-fit:cover;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <button class="btn btn-sm btn-light rounded-circle wishlist-btn"
                                        data-product="{{ $product->name }}" title="Add to Wishlist">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title mb-3">{{ $product->name }}</h5>
                                <h4 class="text-primary mb-3">₦{{ number_format($product->price) }}</h4>
                                @if($product->business)
                                    <p class="text-secondary mb-3 small">By {{ $product->business->business_name }}</p>
                                @endif
                                <!-- Product ID -->
                                <p class="text-secondary mb-3 small">Quote Product #:
                                    PRD-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</p>

                                <button class="btn btn-primary w-100 mb-2 add-to-cart" data-product="{{ $product->name }}"
                                    data-price="{{ $product->price }}">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                                <a href="#" class="btn btn-outline-primary w-100 btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No Results Message -->
                    <div class="col-12 text-center" id="noResults">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            No products found matching your search criteria. Try different keywords.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>
    <!-- Products End -->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wishlistBtn = document.getElementById('wishlistBtn');
            const cartBtn = document.getElementById('cartBtn');
            const wishlistCount = document.getElementById('wishlistCount');
            const cartCount = document.getElementById('cartCount');

            let wishlist = [];
            let cart = [];

            // Wishlist Functionality
            document.querySelectorAll('.wishlist-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const productName = this.getAttribute('data-product');

                    if (!wishlist.includes(productName)) {
                        wishlist.push(productName);
                        this.classList.add('text-danger');
                        this.innerHTML = '<i class="fa fa-heart"></i>';
                        showNotification(`${productName} added to wishlist!`, 'success');
                    } else {
                        wishlist = wishlist.filter(item => item !== productName);
                        this.classList.remove('text-danger');
                        this.innerHTML = '<i class="fa fa-heart"></i>';
                        showNotification(`${productName} removed from wishlist!`, 'info');
                    }

                    wishlistCount.textContent = wishlist.length;
                });
            });

            // Cart Functionality
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', function () {
                    const productName = this.getAttribute('data-product');
                    const productPrice = this.getAttribute('data-price');

                    const existingItem = cart.find(item => item.name === productName);

                    if (!existingItem) {
                        cart.push({ name: productName, price: productPrice, quantity: 1 });
                        this.innerHTML = '<i class="fa fa-check"></i> Added to Cart';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');
                        showNotification(`${productName} added to cart!`, 'success');

                        setTimeout(() => {
                            this.innerHTML = '<i class="fa fa-shopping-cart"></i> Add to Cart';
                            this.classList.remove('btn-success');
                            this.classList.add('btn-primary');
                        }, 2000);
                    } else {
                        existingItem.quantity++;
                        showNotification(`${productName} quantity updated!`, 'info');
                    }

                    cartCount.textContent = cart.length;
                });
            });

            // Wishlist Button Click
            wishlistBtn.addEventListener('click', function () {
                if (wishlist.length === 0) {
                    showNotification('Your wishlist is empty!', 'warning');
                } else {
                    showNotification(`You have ${wishlist.length} item(s) in your wishlist: ${wishlist.join(', ')}`, 'info');
                }
            });

            // Cart Button Click
            cartBtn.addEventListener('click', function () {
                if (cart.length === 0) {
                    showNotification('Your cart is empty!', 'warning');
                } else {
                    let cartSummary = 'Cart Items:\n';
                    let total = 0;
                    cart.forEach(item => {
                        const itemTotal = parseInt(item.price) * item.quantity;
                        total += itemTotal;
                        cartSummary += `${item.name} (x${item.quantity}) - ₦${itemTotal.toLocaleString()}\n`;
                    });
                    cartSummary += `\nTotal: ₦${total.toLocaleString()}`;
                    alert(cartSummary);
                }
            });

            // Notification Function
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
                notification.style.zIndex = '9999';
                notification.style.minWidth = '300px';
                notification.innerHTML = `
                    <i class="fa fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    ${message}
                `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
@endpush