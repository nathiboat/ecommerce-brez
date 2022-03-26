<div class="space-y-6">
    @if ($initialVariation)

        <livewire:product-dropdown :variations="$initialVariation" />

    @endif

    @if ($skuVariant)

        <div>
            {{ $skuVariant->formattedPrice() }}
        </div>
        <div class="space-y-6">

            <x-button wire:click.prevent="addToCart" class="px-8 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"> Add to cart </x-button>

        </div>

    @endif
    <button class="text-gray-600 border rounded-md p-2 hover:bg-gray-200 focus:outline-none">
        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    </button>
</div>
