<x-app-layout>
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-2 gap-4">
                    <div class="col-span-1 grid">
                        <livewire:product-gallery :product="$product" />
                    </div>
                    <div class="col-span-1 p-6 space-y-6">
                        <div>
                            <h1 class="text-gray-700 uppercase text-lg">{{ $product->title }}</h1>
                            <span class="text-gray-500 mt-3"> {{ $product->formattedPrice() }}</span>
                            <hr class="my-3">
                            <div> {{ $product->description }}</div>
                            <div class="mt-2">
                                <label class="text-gray-700 text-sm" for="count">Count:</label>
                                <div class="flex items-center mt-1">
                                    <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                    <span class="text-gray-700 text-lg mx-2">20</span>
                                    <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center mt-1">
                                    <livewire:product-selector :product="$product" />
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </main>
   
</x-app-layout>
