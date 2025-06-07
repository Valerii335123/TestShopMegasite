<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-8">{{__('pages.checkout.header')}}</h1>

    <form wire:submit="submit" class="space-y-6">
        <div>
            <label for="first_name"
                   class="block text-sm font-medium text-gray-700">{{__('pages.checkout.first_name')}}</label>
            <input
                    type="text"
                    id="first_name"
                    wire:model="first_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="last_name"
                   class="block text-sm font-medium text-gray-700">{{__('pages.checkout.last_name')}}</label>
            <input
                    type="text"
                    id="last_name"
                    wire:model="last_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{__('pages.checkout.email')}}</label>
            <input
                    type="email"
                    id="email"
                    wire:model="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">{{__('pages.checkout.phone')}}</label>
            <input
                    type="tel"
                    id="phone"
                    wire:model="phone"
                    placeholder="+380XXXXXXXXX"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="address"
                   class="block text-sm font-medium text-gray-700">{{__('pages.checkout.address')}}</label>
            <input
                    type="text"
                    id="address"
                    wire:model="address"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="delivery_method"
                   class="block text-sm font-medium text-gray-700">{{__('pages.checkout.delivery_method')}}</label>
            <select
                    id="delivery_method"
                    wire:model="delivery_method"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
                <option value="{{\App\Enums\OrderDeliveryMethodType::Pickup}}">{{__('pages.checkout.delivery_method_values.pickup')}}</option>
                <option value="{{\App\Enums\OrderDeliveryMethodType::Post}}">{{__('pages.checkout.delivery_method_values.post')}}</option>
            </select>
            @error('delivery_method') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="payment_method"
                   class="block text-sm font-medium text-gray-700">{{__('pages.checkout.payment_method')}}</label>
            <select
                    id="payment_method"
                    wire:model="payment_method"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
                <option value="{{\App\Enums\OrderPaymentMethodType::Postpaid}}">{{__('pages.checkout.payment_method_values.postpaid')}}</option>
                <option value="{{\App\Enums\OrderPaymentMethodType::Online}}">{{__('pages.checkout.payment_method_values.online')}}</option>
            </select>
            @error('payment_method') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-between items-center pt-6">
            <a
                    href="{{ route('cart') }}"
                    class="text-gray-600 hover:text-gray-800"
            >
                {{__('pages.checkout.back_to_cart')}}
            </a>

            <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700"
            >
                {{__('pages.checkout.submit')}}
            </button>
        </div>
    </form>
</div> 