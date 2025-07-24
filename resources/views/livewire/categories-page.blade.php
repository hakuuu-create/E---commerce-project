<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
      <!-- Added a title section -->
      <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-3">Explore Our Categories</h2>
          <p class="text-lg text-gray-600 dark:text-gray-400">Discover products tailored to your needs</p>
      </div>

      <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach ($categories as $category)
          <a class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1 dark:bg-slate-900 dark:border-gray-700 dark:hover:border-gray-600" 
             href="/products?selected_categories[0]={{ $category->id }}" 
             wire:key="{{ $category->id }}">
             
              <!-- Image container with hover effect -->
              <div class="relative overflow-hidden rounded-t-xl h-48">
                  <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                       src="{{ url('storage', $category->image) }}" 
                       alt="{{ $category->name }}">
                  <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
              </div>
              
              <div class="p-5 flex-grow">
                  <div class="flex justify-between items-start">
                      <div>
                          <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                              {{ $category->name }}
                          </h3>
                          <!-- Optional: Add category description if available -->
                          <!-- <p class="mt-2 text-gray-600 dark:text-gray-400 line-clamp-2">
                              {{ $category->description ?? 'Explore our wide range of products' }}
                          </p> -->
                      </div>
                      <div class="ps-3 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full p-2 group-hover:bg-blue-50 dark:group-hover:bg-gray-600 transition-colors">
                          <svg class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" 
                               xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="m9 18 6-6-6-6" />
                          </svg>
                      </div>
                  </div>
                  
                  <!-- Product count section - Updated -->
                  <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                      </svg>
                      <span>{{ $category->products_count }} {{ $category->products_count == 1 ? 'product' : 'products' }}</span>
                  </div>
              </div>
          </a>
          @endforeach
      </div>
      
      <!-- Optional: Add a call-to-action at the bottom -->
      <div class="mt-16 text-center">
          <p class="text-gray-600 dark:text-gray-400 mb-4">Can't find what you're looking for?</p>
          <a href="/products" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
              Browse All Products
          </a>
      </div>
  </div>
</div>