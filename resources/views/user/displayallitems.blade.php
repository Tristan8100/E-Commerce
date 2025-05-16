<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Display</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .no-image-placeholder {
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6b7280;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        {{Auth::user()->id}} user id
        <div id="product-container">
            <!-- Product will be inserted here by JavaScript -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchdata();
        });

        function fetchdata(){
            $.ajax({
                url: '/getallproduct',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data.length > 0) {
                        let productHtml = '';
                        $.each(res.data, function(index, product) {
                            productHtml += `
                                <div class="border p-4 rounded-lg shadow-md mb-4">
                                    <div class="flex items-center">
                                        <div class="w-24 h-24 flex-shrink-0">
                                            ${product.image_url 
                                                ? `<img src="${product.image_url}" alt="${product.name}" class="w-full h-full object-cover rounded-lg">` 
                                                : `<div class="no-image-placeholder">No Image</div>`}
                                        </div>
                                        <div class="ml-4">
                                            <h2 class="text-lg font-semibold">${product.name}</h2>
                                            <p class="text-gray-600">${product.description}</p>
                                            <p class="text-green-600 font-bold mt-2">₱${parseFloat(product.price).toLocaleString()}</p>
                                            <p class="text-sm ${product.stock > 0 ? 'text-blue-600' : 'text-red-500'}">
                                                ${product.stock > 0 ? `In stock: ${product.stock}` : 'Out of stock'}
                                            </p>
                                        </div>
                                        <div><button onclick="addproduct(event, 1, ${product.id})">add</button></div>
                                    </div>
                                </div>
                            `;
                        });
                        $('#product-container').html(productHtml);
                    } else {
                        $('#product-container').html('<p class="text-center py-8 text-gray-500">No products available</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching product:', error);
                    $('#product-container').html('<p class="text-center py-8 text-red-500">Error loading product data</p>');
                }
            });
        }

        function addproduct(event, number, id){
                    event.preventDefault();
                    $.ajax({
                    url: "/addtocart",  // Your Laravel route
                    type: "POST",
                    data: {
                        product_id: id,
                        quantity: number,
                        _token: "{{ csrf_token() }}" // CSRF protection for Laravel
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText); // Log errors
                        alert("Failed to add to cart!");
                    }
                });
            }

    </script>
    
</body>
</html>