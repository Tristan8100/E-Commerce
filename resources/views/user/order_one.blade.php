<x-layout.user_dashboard>
<x-slot:content>
        <div class="container mx-auto mt-4 border border-green-400 p-2 rounded-md hidden notify">
            <h1 class="font-semibold text-green-600 append"></h1>
        </div>

        
        <div class="container mx-auto mt-4">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h2>
                <p class="text-gray-700 mb-4">Status: 
                    <span class="font-semibold capitalize">{{ $order->status }}</span>
                </p>
        
                <h3 class="text-xl font-semibold mb-2">Items:</h3>
                <ul class="list-disc pl-5">
                    @foreach($order->orderItems as $item)
                    <li class="mb-2">
                        Product ID: {{ $item->product_id }} - 
                        Quantity: {{ $item->quantity }} - 
                        Price: ₱{{ number_format($item->price, 2) }}
                        <img src="{{ $item->product->image_base64 }}" alt="Product Image" class="w-16 h-16 rounded mt-2">
                    </li>
                    @endforeach
                </ul>
        
                <h3 class="text-xl font-semibold mt-4 mb-2">Total Amount:</h3>
                <p class="text-lg font-bold">₱{{ number_format($order->total_price, 2) }}</p>
        
                <div class="mt-4 space-y-2">
                    <p><span class="font-semibold">Payment Method:</span> {{ ucfirst($order->payment) }}</p>
                    @if ($order->payment == 'gcash')
                        <p><span class="font-semibold">Payment ID:</span> {{ $order->payment_id }}</p>
                    @endif
                    <p><span class="font-semibold">Phone Number:</span> {{ $order->phone_number }}</p>
                    <p><span class="font-semibold">Address:</span> {{ $order->address }}</p>
                </div>
        
                <a href="/user/order" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Back to Orders
                </a>
                @if ($order->status == 'pending')
                    <button onclick="cancelOrder({{ $order->id }})" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 cancel">
                        Cancel
                    </button>
                @endif
                
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>
        <script>
            $(window).on('load', () => {
                
            });

            function cancelOrder(id) {
                ajaxFunction(
                    {
                        url: '/cancelorder',
                        method: 'POST',
                        data: {
                            order_id: id
                        },
                        csrfToken: "{{ csrf_token() }}"
                    },
                    handleFetchSuccess,
                    handleFetchFail
                );
            }

            function handleFetchSuccess(data) {
                $('.notify').removeClass('hidden');
                $('.notify').fadeOut(3000);
                $('.append').text(data.message);
                $('.cancel').remove();
            }

            function handleFetchFail(error) {
                console.log(error);
            }

            
        </script>
</x-slot:content>
</x-layout.user_dashboard>