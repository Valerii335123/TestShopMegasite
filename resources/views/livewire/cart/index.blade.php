<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-8">{{ __('pages.cart.header')}}</h1>

    @if(count($this->cartData->items) > 0)
        <div class="space-y-6">
            @foreach($this->cartData->items as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <div class="flex-1">
                        <h3>
                            <a href="{{ route('products.show', $item->product->id) }}"
                               class="text-indigo-600 hover:text-indigo-800">
                                {{ $item->product->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{__('pages.common.sku')}} {{ $item->product->sku }}</p>
                    </div>

                    @if($item->product->stock===0)
                        <div class="flex items-center text-sm text-red-600">
                            {{__('pages.common.out_of_stock')}}
                        </div>
                    @elseif($item->product->stock < $item->quantity )
                        <div class="flex items-center text-sm text-red-600">
                            {{__('pages.common.quantity_is_not_available')}}
                        </div>
                    @endif
                    <div class="flex items-center space-x-4">

                        <div class="flex items-center border rounded-md">
                            <button
                                    wire:click="decrementQuantity({{ $item->product->id }})"
                                    class="px-3 py-1 border-r hover:bg-gray-100"
                                    @if($item->quantity <= 1) disabled @endif>
                                −
                            </button>
                            <span class="px-4 py-1">{{ $item->quantity }}</span>
                            <button
                                    wire:click="incrementQuantity({{ $item->product->id }})"
                                    class="px-3 py-1 border-l hover:bg-gray-100"
                                    @if($item->quantity >= $item->product->stock) disabled @endif>
                                +
                            </button>
                        </div>

                        <div class="w-24 text-right">
                            ${{ number_format(\App\Helpers\MoneyHelper::toDecimal($item->getTotalPrice()), 2) }}
                        </div>

                        <button
                                wire:click="removeItem({{ $item->product->id }})"
                                class="text-red-600 hover:text-red-800"
                        >
                            {{__('pages.cart.button.remove')}}
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center pt-6">
                <div class="text-2xl font-bold">
                    {{__('pages.cart.total')}}
                    ${{ number_format(\App\Helpers\MoneyHelper::toDecimal($this->cartData->getTotalPrice()), 2) }}
                </div>
                <a href=""
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    {{__('pages.cart.button.checkout')}}
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">{{__('pages.cart.empty_text')}}</p>
            <a
                    href="{{ route('products.index') }}"
                    class="text-blue-600 hover:text-blue-800 mt-4 inline-block"
            >
                {{__('pages.cart.empty_link')}}
            </a>
        </div>
    @endif
</div> 