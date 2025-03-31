<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
                <a href="" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Back to Products
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Product Form -->
            <form action="/admin/addproduct" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Name -->
                    <div class="col-span-1">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name*</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name') }}">
                    </div>

                    <!-- Category -->
                    <div class="col-span-1">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1">Select Category</option>
                            
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="col-span-1">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price*</label>
                        <input type="number" step="0.01" name="price" id="price" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('price') }}">
                    </div>

                    <!-- Stock -->
                    <div class="col-span-1">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity*</label>
                        <input type="number" name="stock" id="stock" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('stock') }}">
                    </div>

                    <!-- Image Upload -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image*</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">JPEG, PNG, JPG, or GIF (Max: 5MB)</p>
                        
                        <!-- Image Preview -->
                        <div class="mt-4 hidden" id="imagePreviewContainer">
                            <p class="text-sm font-medium text-gray-700 mb-2">Image Preview:</p>
                            <img id="imagePreview" class="max-w-xs max-h-40 rounded border border-gray-300">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                        <textarea name="description" id="description" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('imagePreview').src = event.target.result;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).ready(function() {
            // Fetch categories when page loads
            $.ajax({
                url: '/admin/getcategories',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // Clear existing options
                    $('#category_id').empty();
                    
                    // Add default option
                    $('#category_id').append('<option value="">Select Category</option>');
                    
                    // Add categories from response
                    $.each(res.data, function(key, category) {
                        $('#category_id').append('<option value="'+category.id+'">'+category.name+'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories:', error);
                    $('#category_id').html('<option value="">Error loading categories</option>');
                }
            });
        });
    </script>
</body>
</html>