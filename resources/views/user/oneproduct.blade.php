<x-layout.user_dashboard>
    <x-slot:content>
        <div class="container mx-auto py-10 px-4 max-w-6xl">
            <!-- Back button -->
            <a href="/items" class="inline-flex items-center mb-6 text-gray-600 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Products
            </a>

            <!-- Product Detail Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="md:flex">
                    <!-- Product Image -->
                    <div class="md:w-1/2 p-6">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1099&q=80" 
                                 alt="Minimalist Watch" 
                                 class="w-full h-full object-contain">
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-8 md:w-1/2">
                        <div class="mb-6">
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">NEW ARRIVAL</span>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3">Minimalist Chronograph Watch</h1>
                            
                        </div>

                        <div class="mb-8">
                            <p class="text-3xl font-bold text-gray-900 mb-4">$249.00</p>
                            <p class="text-green-600 text-sm font-medium mb-2">In Stock (15 available)</p>
                            <p class="text-gray-700 leading-relaxed">
                                This elegant minimalist chronograph watch features a sleek stainless steel case, 
                                genuine leather strap, and precise Japanese quartz movement. The clean dial design 
                                with subtle date display makes it perfect for both casual and formal occasions.
                            </p>
                        </div>

                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <span class="text-gray-700 font-medium mr-4">Quantity:</span>
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100" onclick="decreaseQuantity()">-</button>
                                    <input type="number" id="quantity" value="1" min="1" class="w-12 text-center border-x border-gray-300 py-1">
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button class="px-8 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors flex-1">
                                Add to Cart
                            </button>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Free shipping on orders over $50
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                30-day return policy
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>


        function increaseQuantity() {
            let input = $('#quantity');
            let value = parseInt(input.val());
            input.val(value + 1);
        }

        function decreaseQuantity() {
            let input = $('#quantity');
            let value = parseInt(input.val());
            if (value > 1) {
                input.val(value - 1);
            }
        }
        </script>
    </x-slot:content>
</x-layout.user_dashboard>