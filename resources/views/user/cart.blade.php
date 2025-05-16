<x-layout.user_dashboard>
    <x-slot:content>

   
        <div class="container mt-[50px] mx-auto px-4 py-8 details-contain">
            <!-- Page Header -->
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Your Cart (<span id="cart-count">0</span> items)</h1>
            
            <!-- Cart Items Container -->
            <div class="bg-white shadow rounded-lg shadow overflow-hidden">
                <div class="item-container">
                    <!-- Cart items will be loaded here via AJAX -->
                </div>
                
                <!-- Cart Summary -->
                <div class="p-6 bg-gray-50">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold">Subtotal</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold">Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="flex justify-between items-center mb-6 text-lg">
                        <span class="font-bold">Total</span>
                        <span class="font-bold" id="total">$0.00</span>
                    </div>
                    <button type="submit" onclick='initiateOrder(event)' class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
    
            <!-- will render later -->
            <div class="render-later" style="display: none;">
                H111
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>
        <script>
        //FETCH CART
        $(document).ready(() => {
            initCart();
        });
    
        let cartItems = [];// to access the fetched data outside the function 
        let currentOrder = null;
    
        function initCart() {
            fetchCartData();
    
            $(document).on('change', 'input[name="selected_cart_items"]', updateSummary);
            $(document).on('click', '#checkout-button', submitOrder);
        }
    
        function fetchCartData() {
            ajaxFunction(
                { url: '/getcart', method: 'GET' },
                handleFetchSuccess,
                handleFetchFail
            );
        }
    
        function handleFetchSuccess(res) {
            cartItems = res.data; // to access the fetched data outside the function
            renderCartItems();
            updateSummary();
            $('#cart-count').text(cartItems.length);
        }
    
        function handleFetchFail(xhr, status, error) {
            console.error('Error fetching cart:', error);
        }
    
        function renderCartItems() {
            const html = cartItems.map(createCartItemHtml).join('');
            $('.item-container').html(html);
        }
    
        function createCartItemHtml(item) {
            return `
                <div class="p-6 border-b flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center mr-2">
                        <input type="checkbox" 
                            name="selected_cart_items" 
                            value="${item.id}"
                            class="h-5 w-5 text-blue-600 border-gray-300 rounded"
                            data-price="${item.product.price}"
                            data-quantity="${item.quantity}">
                    </div>
                    <div class="flex-shrink-0">
                        ${item.product.image_url ? 
                            `<img src="${item.product.image_url}" class="w-24 h-24 object-cover rounded">` : 
                            `<div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded"><span class="text-gray-400">No image</span></div>`}
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-semibold text-lg">${item.product.name}</h3>
                        <p class="text-sm text-gray-500">${item.product.category?.name || 'Uncategorized'}</p>
                        <p class="text-gray-700 mt-2">$${item.product.price}</p>
                    </div>
                    <div class="flex sm:flex-col justify-between items-end">
                        <div class="flex items-center border rounded">
                            <button onclick="updateQuantity(${item.product.id}, 'subtract', 1, event)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200">-</button>
                            <span class="px-3 quantity-display">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.product.id}, 'add', 1, event)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200">+</button>
                        </div>
                        <button class="text-red-500 hover:text-red-700 mt-2 sm:mt-0" onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            `;
        }
    
        //UPDATE QUANTITY
        function updateQuantity(id, action, stock, event) {
            event.preventDefault();
    
            ajaxFunction(
                {
                    url: '/updatecart',
                    method: 'POST',
                    data: { product_id: id, action, quantity: stock },
                    csrfToken: "{{ csrf_token() }}"
                },
                (res) => {
                    console.log(res);
                    fetchCartData();
                },
                
                (xhr) => {
                    console.error(xhr.responseText);
                    alert("Failed to update cart!");
                }
            );
        }
    
        function updateSummary() {
            let subtotal = 0;
            let quant = 0;
    
            $('input[name="selected_cart_items"]:checked').each(function () {
                const price = parseFloat($(this).data('price'));
                const quantity = parseInt($(this).data('quantity'));
                subtotal += price * quantity;
                quant += quantity;
            });
    
            $('#subtotal').text('$' + subtotal.toFixed(2));
            $('#total').text('$' + subtotal.toFixed(2));
        }
    
        //INITIATE ORDER
        function initiateOrder(event) {
            event.preventDefault();
    
            const selectedItems = [];
            let totalPrice = 0;
    
            $('input[name="selected_cart_items"]:checked').each(function () {
                selectedItems.push($(this).val());
                totalPrice += parseFloat($(this).data('price')) * parseInt($(this).data('quantity'));
            });
    
            ajaxFunction(
                {
                    url: '/checkoutpage',
                    method: 'POST',
                    data: {
                        dataarray: selectedItems,
                        price: totalPrice
                    },
                    csrfToken: "{{ csrf_token() }}"
                },
                (res) => {
                    if (res.status === 'success') {
                        currentOrder = res;
                        renderCheckout(res);
                    }
                },
                (xhr) => {
                    console.error(xhr.responseText);
                    alert("Failed to initiate order!");
                }
            );
        }
    
        //SPA CHECKOUT PAGE
        function renderCheckout(response) {
            $(".details-contain").html(response.html).show();
    
            const itemsHtml = response.order_items.map(item => `
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                        <img src="${item.imageproduct}" alt="${item.name}" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="font-medium">${item.name}</h3>
                        <p class="text-gray-500 text-sm">Stock: ${item.stock}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">₱${parseFloat(item.price).toLocaleString()}</p>
                        <p class="text-gray-500 text-sm">Qty: ${item.purchased}</p>
                    </div>
                </div>
            `).join('');
    
            $('.put-item').html(itemsHtml);
            $('.put-total').html(response.total);
        }
    
        //SUBMIT ORDER
        function submitOrder(e) {
            e.preventDefault();
    
            const address = $('.address-user').val().trim();
            const phone = $('.number-user').val().trim();
            const paymentMethod = $('input[name="payment"]:checked').attr("id");
    
            if (!address) return alert("Please enter your shipping address.");
            if (!paymentMethod) return alert("Please select a payment method.");
    
            ajaxFunction(
                {
                    url: '/submitorder',
                    method: 'POST',
                    data: {
                        total: currentOrder.total,
                        address_user: address,
                        payment_user: paymentMethod,
                        phone_user: phone,
                        dataarray: currentOrder.order_items
                    },
                    csrfToken: "{{ csrf_token() }}"
                },
                (res) => {
                    if (res.pay) {
                        window.location.href = res.pay; //OrderController line 188 reference, this is the paymongo checkout page btw
                    } else {
                        alert("Failed to create checkout session.");
                    }
                },
                (xhr) => {
                    console.error(xhr.responseText);
                    alert("Failed to submit order!");
                }
            );
        }
    
        //REMOVE FROM CART
        function removeFromCart(cartItemId) {
            ajaxFunction(
                {
                    url: '/removefromcart',
                    method: 'POST',
                    data: { cart_item_id: cartItemId },
                    csrfToken: "{{ csrf_token() }}"
                },
                fetchCartData,
                (xhr) => {
                    console.error(xhr.responseText);
                    alert("Failed to remove item from cart!");
                }
            );
        }
        </script>
      
    </x-slot:content>
</x-layout.user_dashboard>