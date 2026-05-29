<x-app-layout>
    <div class="w-[400px] text-white bg-emerald-500 px-3 py-2 text-center  mx-auto">
        Thanks for shopping with us {{
            $session->customer_details->name
        }}. Your payment was successful.
    </div>
    
</x-app-layout>
