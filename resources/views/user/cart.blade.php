<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page Template</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-3xl details-contain">
        <!-- Page Header -->
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Your Cart (<span id="cart-count">0</span> items)</h1>
        
        <!-- Cart Items Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
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
                <button type="submit" onclick='initiateorder(event)' class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
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
    <script>
        $(document).ready(function() {
            fetchdata();
            
            // Handle checkbox changes
            $(document).on('change', 'input[name="selected_cart_items"]', function() {
                updateSummary();
            });
        });

        let cartItems = []; // Store cart items globally

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

        function updatequantity(id, action, stock, event){
            event.preventDefault();
            $.ajax({
                url: "/updatecart",
                type: "POST",
                data: {
                    product_id: id,
                    action: action,
                    quantity: stock,
                    _token: "{{ csrf_token() }}" 
                },
                success: function (response) {
                    console.log(response);
                    fetchdata(); // Refresh the cart data
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to update cart!");
                }
            });
        }

        function updateSummary() {
            let subtotal = 0;
            let quant = 0;

            // Loop through all checked checkboxes
            $('input[name="selected_cart_items"]:checked').each(function() {
                const price = parseFloat($(this).data('price'));
                const quantity = parseInt($(this).data('quantity'));
                subtotal += price * quantity;
                quant += quantity;
            });
            
            $('#subtotal').text('$' + quant.toFixed(2));
            $('#total').text('$' + subtotal.toFixed(2));
        }

        function initiateorder(event) {
            event.preventDefault();
            const item = [];
            let allprice = 0;
            $('input[name="selected_cart_items"]:checked').each(function() {
                item.push($(this).val());

                allprice += parseFloat($(this).data('price')) * parseFloat($(this).data('quantity'));
            });

            console.log(item);

            $.ajax({
                url: "/checkoutpage",
                type: "POST",
                data: {
                    dataarray: item,
                    price: allprice,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    //fetchdata();
                    if(response.status === 'success'){
                        checkout(response);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to remove item from cart!");
                }
            });
            
        }

        function removeFromCart(cartItemId) {
            $.ajax({
                url: "/removefromcart",
                type: "POST",
                data: {
                    cart_item_id: cartItemId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    fetchdata(); // Refresh the cart data
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to remove item from cart!");
                }
            });
        }

        let totalprice = 0;
        let address1 = "";
        let payment = "";


        function checkout(res) {
            $(".details-contain").html("");
            console.log(res.html);
            //render html template
            $(".details-contain").html(res.html).show();
            let value = "";
            res.order_items.forEach(element => {
                value += `
                             <div class="flex items-center">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                    <img src="${element.imageproduct}" alt="${element.name}" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="font-medium">${element.name}</h3>
                                    <p class="text-gray-500 text-sm">Stock: ${element.stock}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">₱${parseFloat(element.price).toLocaleString()}</p>
                                    <p class="text-gray-500 text-sm">Qty: ${element.purchased}</p>
                                </div>
                            </div>
                `;
            });
            $('.put-item').html(value);
            $('.put-total').html(res.total);
            totalprice = res.total;

            // need to put on inside the function
            $("#checkout-button").click(function (e) {
                e.preventDefault();
                console.log('click');

                // Get the shipping address
                let address = $('.address-user').val().trim();

                let phone = $('.number-user').val().trim();

                // Get the selected payment method
                let paymentMethod = $('input[name="payment"]:checked').attr("id");

                // Validate inputs
                if (!address) {
                    alert("Please enter your shipping address.");
                    return;
                }
                if (!paymentMethod) {
                    alert("Please select a payment method.");
                    return;
                }


                // Send data via AJAX
                console.log(totalprice);
                console.log(address);
                console.log(phone);
                console.log(paymentMethod);
                console.log(res.order_items);


                $.ajax({
                    url: "/submitorder",
                    type: "POST",
                    data: {
                        total: totalprice,
                        address_user: address,
                        payment_user: paymentMethod,
                        phone_user: phone,
                        dataarray: res.order_items,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.pay) {
                            window.location.href = response.pay; // Redirect to PayMongo checkout
                        } else {
                            alert("Failed to create checkout session.");
                        }
                        
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("Failed to remove item from cart!");
                    }
                });

               
            });

        }

        
        


            



        
    </script>
</body>
</html>