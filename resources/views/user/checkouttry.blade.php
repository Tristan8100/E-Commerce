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
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 mb-1">Address</label>
                            <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 address-user">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 mb-1">Phone</label>
                            <input type="number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 number-user">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                <div class="space-y-4">
                    <div class="flex items-center p-4 border rounded-lg">
                        <input type="radio" name="payment" id="gcash" checked class="h-5 w-5 text-blue-600">
                        <label for="credit-card" class="ml-3 flex-1">
                            <span class="block font-medium">Gcash</span>
                            <span class="block text-sm text-gray-500">Pay with Gcash</span>
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l18 8-8-18-18 8z" />
                        </svg>
                    </div>
                    <div class="flex items-center p-4 border rounded-lg">
                        <input type="radio" name="payment" id="cod" class="h-5 w-5 text-blue-600">
                        <label for="paypal" class="ml-3 flex-1">
                            <span class="block font-medium">COD</span>
                            <span class="block text-sm text-gray-500">Cash On Delivery</span>
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l18 8-8-18-18 8z" />
                        </svg>
                    </div>
                </div>

                <!-- Credit Card Form (shown when credit card selected)
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
                </div> -->
            </div>
        </div>

        <!-- Right Column - Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <!-- Products List -->
                <div class="space-y-4 mb-6 put-item">
                    
                </div>
                
                <!-- Order Totals -->
                <div class="border-t pt-4">
                    <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
                        <span>Total</span>
                        <span class="put-total"></span>
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