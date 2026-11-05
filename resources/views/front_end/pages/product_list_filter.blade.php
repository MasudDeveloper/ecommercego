<div id="products-container" class="grid-view grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 xl:gap-6">
                
@foreach ($products as $product)
<x-product-card :store="$store" :product="$product" />
@endforeach
</div>

<div class="flex justify-center md:mt-8 mt-5 pagination-wrapper">
    <div class="flex items-center gap-2">
        @if($products->onFirstPage())
            <span class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-gray-300 text-gray-500 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
        @else
            <button onclick="product_page_filter({{ $products->currentPage() - 1 }})"
                class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>
        @endif

        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if($page == $products->currentPage())
                <span class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-primary bg-primary text-white">
                    {{ $page }}
                </span>
            @else
                <button onclick="product_page_filter({{ $page }})"
                    class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                    {{ $page }}
                </button>
            @endif
        @endforeach

        @if($products->hasMorePages())
            <button onclick="product_page_filter({{ $products->currentPage() + 1 }})"
                class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>
        @else
            <span class="p-1 h-8 w-8 flex items-center justify-center rounded-md border border-gray-300 text-gray-500 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </span>
        @endif
    </div>
</div>