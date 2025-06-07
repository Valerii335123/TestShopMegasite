<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h1 class="text-3xl font-bold text-green-600 mb-4">{{__('pages.checkout_success.title')}}</h1>
    <p class="text-gray-600 mb-8">{{__('pages.checkout_success.content')}}</p>

    <a href="{{ route('products.index') }}"
       class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 inline-block">
        {{__('pages.checkout_success.button_text')}}
    </a>
</div> 