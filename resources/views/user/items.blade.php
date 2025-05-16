
<x-layout.user_dashboard>
    <x-slot:content>
    
    <h1 class="text-3xl font-bold mb-6 text-center mt-[50px]">Product List</h1>

    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 render-products">
      <!-- Product Card -->
      
    </div>

    <div class="modal border hidden border-red-800 absolute left-[50%] top-[50%] transform -translate-x-1/2 -translate-y-1/2">
        <!-- Product Detail Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
          <div class="md:flex">
              <!-- Product Image -->
              <div class="md:w-1/2 p-6">
                  <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden">
                      <img class="image-container" src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1099&q=80" 
                          alt="Minimalist Watch" 
                          class="w-full h-full object-contain">
                  </div>
              </div>
              
              <!-- Product Info -->
              <div class="p-8 md:w-1/2">
                  <div class="mb-6">
                      <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3 title-container">Minimalist Chronograph Watch</h1>
                      
                  </div>

                  <div class="mb-8">
                      <p class="text-3xl font-bold text-gray-900 mb-4 price-container">$249.00</p>
                      <p class="text-green-600 text-sm font-medium mb-2 stock-container">In Stock (15 available)</p>
                      <p class="text-gray-700 leading-relaxed description-container">
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
                      <button class="px-8 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors flex-1 addcart">
                          Add to Cart
                      </button>
                  </div>

                  <div class="mt-8 pt-6 border-t border-gray-200">
                      <div class="flex items-center text-sm text-gray-600">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                          </svg>
                          Free shipping on orders
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

  <script src="{{ asset('js/ajax.js') }}"></script>
  <script>
    //FETCHING PRODUCT
    $(document).ready(() => {
      ajaxFunction(
        { url: '/getallproduct', method: 'GET' },
        handleFetchSuccess,
        handleFetchFail
      );
    });

    function handleFetchFail(xhr, status, error) {
        console.log(error);
    }

    function handleFetchSuccess(res) {
        $('.render-products').html(""); // Clear the container
        res.data.forEach(product => {
            $('.render-products').append(`
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
                  <img src="${product.image_url}" alt="${product.name}" class="w-full h-48 object-cover">
                  <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">${product.name}</h2>
                    <p class="text-gray-600 mb-2">${product.description}</p>
                    <p class="text-sm text-blue-500 mb-2">Category: ${product.category.name}</p>
                    <p class="text-lg font-bold text-green-600 mb-2">$${product.price}</p>
                    <p class="text-sm text-gray-700">Stocks: ${product.stock}</p>
                    <button class="inline-block mt-4 px-4 py-2 bg-red-200 text-black rounded hover:bg-red-300 transition view" onclick="view_original('${encodeURIComponent(JSON.stringify(product))}')">View</buttom>
                    <button class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition add-to-cart" onclick="addproduct(event, 1, ${product.id})">Add to Cart</button>
                  </div>
                </div>
          `);
      });
    }

    //ADD TO CART
    function addproduct(event, number, id){
      event.preventDefault();
      ajaxFunction(
        {
          url: '/addtocart',
          method: 'POST',
          data: {
            product_id: id,
            quantity: number,
          },
          csrfToken: "{{ csrf_token() }}"
        },
        addcartsuccess,
        addcartfail
      );            
    }

    function addcartsuccess(res) {
        alert('Product added to cart successfully!');
    }

    function addcartfail(xhr, status, error) {
        console.log(error);
        alert('Failed to add product to cart.');
    }

    function view(id) {
      ajaxFunction(
            { url: '/getproduct/' + id, method: 'GET' },
            viewSuccess,
            viewFail
        );
    }

    //ONCLICK VIEW
    function view_original(object_data) {
      const product = JSON.parse(decodeURIComponent(object_data));
      $('.image-container').attr('src', product.image_url);
      $('.title-container').text(product.name);
      $('.description-container').text(product.description);
      $('.price-container').text(product.price);
      $('.stock-container').text(product.stock);
      $('.addcart').on('click', function(event) {
        addproduct(event, 1, product.id); // Pass number and ID
      });
      
      $('.modal').fadeToggle(300); // Adds a fade animation with a duration of 300ms
      console.log(product);
    }
      
    function viewSuccess(res){

    }

    function viewFail(xhr, status, error){
        console.log(error);
    }

    $(document).on('click', function(event) {
      if (!$(event.target).closest('.modal').length && !$(event.target).closest('.view').length) {
          $('.modal').fadeOut(300);
      }
    });

    //ONCLICK QUANTITY
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
    //description-container  stock-container  price-container  title-container  image-container

  </script>
    </x-slot:content>
  </x-layout.user_dashboard>