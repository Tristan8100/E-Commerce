<x-layout.user_dashboard>
<x-slot:content>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-red-500 mb-8">Order Management</h1>
    
    <!-- Status Filter -->
    <div class="mb-6 flex space-x-4 filter-buttons">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        All Orders
      </button>
      <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Pending
      </button>
      <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Processing
      </button>
      <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Completed
      </button>
      <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Cancelled
      </button>
    </div>
    
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Orders Management</h1>
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Table Container with Horizontal Scroll -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Enhanced Scrollable Table Container -->
                <div class="overflow-x-auto" style="max-height: 70vh; overflow-y: auto;">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Products</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Payment</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Address</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Phone</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 all-orders">
                            <!-- Rows will be inserted here dynamically -->

                        </tbody>
                    </table>
                    <div class="links"></div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">12</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <div onclick="paginateOrders(currentPage - 1)" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            
                            <div onclick="paginateOrders(currentPage + 1)" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                               
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
                    
        </div>
    </div>
   
  </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            ajaxFunction(
                { url: '/getorder', method: 'GET' },
                handleFetchSuccess,
                handleFetchFail
            );
        });

        let currentPage = 0;
        let lastPage = 0;
        function handleFetchSuccess(data) {
            console.log(data);
            $('.all-orders').empty();
            currentPage = data.orders.current_page;
            lastPage = data.orders.last_page;
            console.log(currentPage);
            console.log(lastPage);
            data.orders.data.forEach(order => {
                console.log(`Order ID: ${order.id}, Status: ${order.status}, Total: ${order.total_price}`);
                $('.all-orders').append(`
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${order.id}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            ${order.order_items.map(item => `- ${item.product.name} (x${item.quantity})`).join('<br>')}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${order.total_price}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.payment}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${order.status}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.address}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.phone_number}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3" onclick='viewOrder(${order.id});'>View</button>
                        </td>
                    </tr>`);
                order.order_items.forEach(item => {
                    console.log(`  Item: ${item.product.name}, Quantity: ${item.quantity}, Price: ${item.price}`);
                });
            });
        }
        function handleFetchFail(error) {
            // Handle the error response here
            console.error(error);
        }

        function viewOrder(orderId) {
            // Handle the view order action here
            console.log(`View order with ID: ${orderId}`);
            window.location.href = `/user/order/${orderId}`;
        }

        $(document).on('click', '.filter-buttons button', function() {
            $('.filter-buttons button').removeClass('bg-blue-600 text-white').addClass('bg-gray-200 text-gray-700');
            $(this).removeClass('bg-gray-200 text-gray-700').addClass('bg-blue-600 text-white');
            
            // Fetch and display orders based on the selected filter
            const filter = $(this).text().trim();
            console.log(`Filter selected: ${filter}`);
            // Implement the filtering logic here
            if (filter === 'All Orders') {
                ajaxFunction(
                    { url: '/getorder', method: 'GET' },
                    handleFetchSuccess,
                    handleFetchFail
                );
            } else {
                // Example: Filter orders based on status
                ajaxFunction(
                    { url: `/getorder?status=${filter}`, method: 'GET' },
                    handleFetchSuccess,
                    handleFetchFail
                );
            }
        });


        function paginateOrders(page) {
            if (currentPage > 0 && page <= lastPage) {
                // Fetch and display orders for the selected page
                ajaxFunction(
                    { url: `/getorder?page=${page}`, method: 'GET' },
                    handleFetchSuccess,
                    handleFetchFail
                );
            }
        }
    </script>
</x-slot:content>
</x-layout.user_dashboard>