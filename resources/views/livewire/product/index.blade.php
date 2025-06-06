@php use App\Helpers\MoneyHelper; @endphp

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    {{__('pages.product.index.title')}}
                </h2>
            </div>
            <div class="flex space-x-4">
                <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="{{__('pages.product.index.search_placeholder')}}"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                @error('search')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <select
                        wire:model.live.debounce.300ms="sort"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                    <option value="" selected>{{__('pages.product.index.sort.select')}}</option>
                    <option value="name">{{__('pages.product.index.sort.name_asc')}}</option>
                    <option value="-name">{{__('pages.product.index.sort.name_desc')}}</option>
                    <option value="price">{{__('pages.product.index.sort.price_asc')}}</option>
                    <option value="-price">{{__('pages.product.index.sort.price_desc')}}</option>
                    <option value="stock">{{__('pages.product.index.sort.stock_asc')}}</option>
                    <option value="-stock">{{__('pages.product.index.sort.stock_desc')}}</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">
                            <a href="{{ route('products.show', $product) }}"
                               class="text-indigo-600 hover:text-indigo-800">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{__('pages.common.sku')}} {{ $product->sku }}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-lg font-bold">${{ number_format(MoneyHelper::toDecimal($product->price), 2) }}</span>
                            <span class="text-sm {{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->isInStock() ? __('pages.common.in_stock') : __('pages.common.out_of_stock') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">{{__('pages.product.index.no_products')}}</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div> 