<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Your Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
            <div class="flex mt-2">
                <div class="w-1/3 h-1 bg-blue-600"></div>
                <div class="w-1/3 h-1 bg-gray-300"></div>
                <div class="w-1/3 h-1 bg-gray-300"></div>
            </div>
        </header>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column - Shipping/Payment -->
            <div class="lg:w-2/3">
                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-1">First Name</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Last Name</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-1">Address</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">City</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Postal Code</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-1">Country</label>
                                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>United Kingdom</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 border rounded-lg">
                            <input type="radio" name="payment" id="credit-card" checked class="h-5 w-5 text-blue-600">
                            <label for="credit-card" class="ml-3 flex-1">
                                <span class="block font-medium">Credit Card</span>
                                <span class="block text-sm text-gray-500">Pay with Visa, Mastercard, etc.</span>
                            </label>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l18 8-8-18-18 8z" />
                            </svg>
                        </div>
                        <div class="flex items-center p-4 border rounded-lg">
                            <input type="radio" name="payment" id="paypal" class="h-5 w-5 text-blue-600">
                            <label for="paypal" class="ml-3 flex-1">
                                <span class="block font-medium">PayPal</span>
                                <span class="block text-sm text-gray-500">Pay with your PayPal account</span>
                            </label>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l18 8-8-18-18 8z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Credit Card Form (shown when credit card selected) -->
                    <div class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-1">Card Number</label>
                                <input type="text" placeholder="1234 5678 9012 3456" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Expiration Date</label>
                                <input type="text" placeholder="MM/YY" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">CVV</label>
                                <input type="text" placeholder="123" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-1">Name on Card</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <!-- Products List -->
                    <div class="space-y-4 mb-6">
                        <div class="put-order">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                    <img src="https://via.placeholder.com/80" alt="Product" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="font-medium">Premium Headphones</h3>
                                    <p class="text-gray-500 text-sm">Color: Black</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">$199.99</p>
                                    <p class="text-gray-500 text-sm">Qty: 1</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                <img src="https://via.placeholder.com/80" alt="Product" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-medium">Wireless Charger</h3>
                                <p class="text-gray-500 text-sm">Color: White</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">$29.99</p>
                                <p class="text-gray-500 text-sm">Qty: 2</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Totals -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span>$259.97</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Shipping</span>
                            <span>$5.99</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tax</span>
                            <span>$20.80</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
                            <span>Total</span>
                            <span>$286.76</span>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <button id="checkout-button" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition mt-6">
                        Complete Order
                    </button>
                    
                    <!-- Secure Payment Info -->
                    <div class="flex items-center justify-center mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="ml-2 text-sm text-gray-500">Secure Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {
            fetchdata();
            
        });

        function fetchdata(){
            $.ajax({
                url: '/getcart',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    cartItems = res.data; // Store cart items
                    $('#cart-count').text(cartItems.length);
                    
                    let productHtml = '';
                    $.each(cartItems, function(index, item) {
                        productHtml += `
                            <div class="p-6 border-b flex flex-col sm:flex-row gap-4">
                                <!-- Checkbox -->
                                <div class="flex items-center mr-2">
                                    <input type="checkbox" 
                                        name="selected_cart_items" 
                                        value="${item.id}"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        data-price="${item.product.price}"
                                        data-quantity="${item.quantity}">
                                </div>
                                
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    ${item.product.image_url ? 
                                        `<img src="${item.product.image_url}" alt="${item.product.name}" class="w-24 h-24 object-cover rounded">` : 
                                        `<div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400">No image</span>
                                        </div>`
                                    }
                                </div>
                                
                                <!-- Product Info -->
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg">${item.product.name}</h3>
                                    <p class="text-sm text-gray-500">${item.product.category?.name || 'Uncategorized'}</p>
                                    <p class="text-gray-700 mt-2">$${item.product.price}</p>
                                </div>
                                
                                <!-- Quantity & Actions -->
                                <div class="flex sm:flex-col justify-between items-end">
                                    <div class="flex items-center border rounded">
                                        <button onclick="updatequantity(${item.product.id}, 'subtract', 1, event)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200">-</button>
                                        <span class="px-3 quantity-display">${item.quantity}</span>
                                        <button onclick="updatequantity(${item.product.id}, 'add', 1, event)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200">+</button>
                                    </div>
                                    <button 
                                        class="text-red-500 hover:text-red-700 mt-2 sm:mt-0"
                                        onclick="removeFromCart(${item.id})">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    $('.item-container').html(productHtml);
                    updateSummary(); // Initialize summary
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching product:', error);
                }
            });
        }
    </script>
</body>
</html>