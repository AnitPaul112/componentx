<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Compare Products') }}
      </h2>
  </x-slot>

  <style>
      /* General Page Styling */
      body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
      }

      main {
          padding: 20px;
      }

      /* Product Grid Styling */
      .product-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
          gap: 20px;
          justify-items: center;
      }

      .product-card {
          background-color: #fff;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          text-align: center;
          transition: transform 0.3s, box-shadow 0.3s;
          width: 100%;
          max-width: 300px;
      }

      .product-card:hover {
          transform: translateY(-10px);
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      }

      .product-card img {
          width: 100%;
          height: auto;
          border-radius: 8px;
          object-fit: cover;
          margin-bottom: 15px;
      }

      .product-card h2 {
          font-size: 1.5rem;
          color: #333;
          margin-bottom: 10px;
      }

      .product-card .price {
          font-size: 1.25rem;
          font-weight: bold;
          color: #e91e63;
          margin-bottom: 10px;
      }

      /* Remove Button Styling */
      .remove-button {
          background-color: #e91e63;
          color: #fff;
          padding: 10px 20px;
          border-radius: 5px;
          text-decoration: none;
          font-weight: bold;
          transition: background-color 0.3s;
          margin-top: 10px;
          display: inline-block;
      }

      .remove-button:hover {
          background-color: #d32f2f;
      }

      /* Styling for the empty case */
      .no-products {
          text-align: center;
          font-size: 1.25rem;
          color: #666;
      }
  </style>

  <main>
      @if(count($compareProducts) > 0)
          <div class="product-grid">
              @foreach($compareProducts as $product)
                  <div class="product-card" id="product-{{ $product->product_id }}">
                      <img src="{{ route('product.image', $product->product_id) }}" alt="{{ $product->product_name }}">

                      <h2>{{ $product->product_name }}</h2>
                      <p class="price">${{ $product->product_price }}</p>

                      <!-- Add any product comparison details here -->
                      <p><strong>Description:</strong> {{ $product->product_description ?? 'No description available.' }}</p>
                      <p><strong>Brand:</strong> {{ $product->brand ?? 'No brand specified' }}</p>

                      <!-- Remove Button -->
                      <a href="javascript:void(0);" class="remove-button" onclick="removeFromCompare({{ $product->product_id }})">Remove</a>
                  </div>
              @endforeach
          </div>
      @else
          <p class="no-products">No products selected for comparison.</p>
      @endif
  </main>

  <script>
      function removeFromCompare(productId) {
          fetch(`/compare/remove/${productId}`, {
              method: 'GET',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
              },
          })
          .then(response => response.json())
          .then(data => {
              // If the removal was successful, remove the product from the page
              if (data.success) {
                  // Remove the product card from the DOM
                  const productCard = document.getElementById('product-' + productId);
                  if (productCard) {
                      productCard.remove();
                  }
              }
          })
          .catch(error => console.log('Error removing product:', error));
      }
  </script>

</x-app-layout>
