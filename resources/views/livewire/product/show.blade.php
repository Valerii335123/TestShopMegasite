@php use App\Helpers\MoneyHelper; @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
        <!-- Product image -->
        <div class="flex flex-col">
            <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                    @if($product->getFirstMediaUrl('images'))
                        <img src="{{$product->getFirstMediaUrl('images')}}">
                    @else
                        <span class="text-lg">{{__('pages.product.empty_image')}}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product info -->
        <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>

            <div class="mt-3">
                <p class="text-3xl text-gray-900">${{ number_format(MoneyHelper::toDecimal($product->price), 2) }}</p>
            </div>

            <div class="mt-6">
                <h3 class="text-3 font-extrabold tracking-tight text-gray-">{{__('pages.product.description')}}</h3>
                <div class="text-base text-gray-700 space-y-6">
                    {{ $product->description }}
                </div>
            </div>

            <div class="mt-6">
                <div class="flex items-center">
                    <div class="ml-4">
                        <h3 class="text-sm text-gray-600">{{__('pages.common.sku')}} {{ $product->sku }}</h3>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex items-center">
                    <div @class([
                        'text-sm',
                        'text-green-600' => $product->isInStock(),
                        'text-red-600' => !$product->isInStock(),
                    ])>
                        {{ $product->isInStock() ? __('pages.common.in_stock') : __('pages.common.out_of_stock') }}
                    </div>
                </div>
            </div>

            <div class="mt-8 flex">
                <button
                        @class([
                            'w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                            'opacity-50 cursor-not-allowed' => !$product->isInStock(),
                        ])
                        @disabled(!$product->isInStock())
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div> 