<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> 
            Thanks for your order
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-grey-200">
                    Your order (#{{ $order->id }}) has been placed.

                    <a href="/register" class="text-indigo-500">Create an account</a>
                    manage you orders.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>