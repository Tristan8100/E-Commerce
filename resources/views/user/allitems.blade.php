
<x-layout.user_dashboard>
  <x-slot:content>
    <x-design.header></x-design.header>
  
    <x-design.video></x-design.video>

    @if(session('success'))
    <div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
        {{ session('error') }}
    </div>
    @endif
  
      <!-- gallery -->
      <div class="mt-[100px] flex justify-center ml-[150px]">
          <div class="p-[20px] w-[900px] grid grid-cols-2">
              <div class="border border-yellow-500 w-full"><img src="{{ asset('images/keq.jpg') }}" alt="Gallery Image 1"></div>
              <div class="border border-yellow-500 w-full"><img src="{{ asset('images/show.png') }}" alt="Gallery Image 2"></div>
              <div class="border border-yellow-500 w-full col-span-2"><img class="w-full" src="{{ asset('images/keq2.jpg') }}" alt="Gallery Image 4"></div>
          </div>
      </div>
  
  
      <div class="text-3xl font-bold text-center mt-[150px] text-red-950">
          featured products
      </div>
      <!-- Scrollable Wrapper -->
  
      <!-- product -->
      <div class="max-w-7xl mx-auto">
          <!-- Title -->
          <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
      
          <!-- Slider Container (Hidden Scrollbar) -->
          <div class="relative group">
            <!-- Fade-out edges (visual hint) -->
            <div class="absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>
      
            <!-- Scrollable Product Cards -->
            <div class="overflow-x-auto scroll-smooth snap-x hide-scrollbar pb-4" style="-webkit-overflow-scrolling: touch;">
              <div class="flex space-x-6 w-max px-4 render-products">
                <!-- Product Card 1 -->
   
              </div>
            </div>
          </div>
      </div>
    
    
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script>
  
      ajaxFunction(
        { url: '/getallproduct', method: 'GET' },
        handleFetchSuccess,
        handleFetchFail
      );
  
      function handleFetchSuccess(res){
        $('.render-products').html(""); // Clear the container
        
        res.data.forEach(product => {
            $('.render-products').append(`
                <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-sm hover:shadow-md transition-all overflow-hidden snap-start">
                  <img src="${product.image_url}" alt="Product" class="w-full h-48 object-cover">
                  <div class="p-5">
                    <h3 class="font-bold text-lg mb-2">${product.name}</h3>
                    <p class="text-gray-600 mb-4">${product.description}</p>
                    <div class="flex justify-between items-center">
                      <span class="font-bold text-lg">${product.price}</span>
                      <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">View</button>
                    </div>
                  </div>
                </div>
            `);
        });
      }
  
      function handleFetchFail(xhr, status, error){
        console.log(error);
      }
  
      $(document).ready(function() {
            const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
            delay: 3000,
            },
            pagination: {
            el: '.swiper-pagination',
            clickable: true,
            },
            navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
            },
        });
      });
    
    </script>
  </x-slot:content>
</x-layout.user_dashboard>
