<div>
    <div class="w-full mx-auto py-2 px-6 rounded-md shadow-md">
        <h1 class="text-lg font-semibold mb-4">{{ __('Sync Your Inventory with Ecommerce') }}</h1>
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 py-2 px-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 text-red-800 py-2 px-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <div class="flex flex-wrap">
            <div class="mt-5 w-1/2 sm:w-full">

                <div class="mb-4">
                    <div class="flex items-center">
                        @if (settings()->custom_store_url)
                            <p class="font-medium">{{ __('Ecommerce Platform') }}:</p>
                            <p class="ml-2">{{ __('Custom') }}</p>
                            <p class="ml-2">{{ settings()->custom_store_url }}</p>
                            <p class="ml-2">{{ settings()->custom_api_key }}</p>
                        @endif
                        @if (settings()->woocommerce_store_url)
                            <p class="font-medium">{{ __('Ecommerce Platform') }}:</p>
                            <p class="ml-2">{{ __('WooCommerce') }}</p>
                            <p class="ml-2">{{ settings()->woocommerce_api_key }}</p>
                            <p class="ml-2">{{ settings()->woocommerce_store_url }}</p>
                        @endif
                        @if (settings()->shopify_store_url)
                            <p class="font-medium">{{ __('Ecommerce Platform') }}:</p>
                            <p class="ml-2">{{ __('Shopify') }}</p>
                            <p class="ml-2">{{ settings()->shopify_api_key }}</p>
                            <p class="ml-2">{{ settings()->shopify_store_url }}</p>
                        @endif

                    </div>
                    <div class="flex items-center mt-2">
                        <p class="font-medium">{{ __('Missing Products') }} :</p>
                        <p class="ml-2">
                            @if ($missingProducts)
                                {{ $missingProducts }}
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center mt-2">
                        <p class="font-medium">{{ __('Inventory Products') }} :</p>
                        <p class="ml-2">
                            {{ $inventoryProducts }}
                        </p>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="font-medium">{{ __('Website URL') }}</p>
                    <input type="text" wire:model.lazy="custom_store_url" id="url" name="url"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button wire:click="countNotExistingProducts" type="button"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Count missing products') }}
                </button>

                <button wire:click="$emit('syncModal')"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
                    {{ __('Sync Products') }}
                </button>
                <button wire:click="$emit('loginModal')"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="mt-5 mb-4 w-1/2 sm:w-full">

                @if ($token)
                    <div class="mt-4">
                        <p class="font-medium">{{ __('Your API Token') }}</p>

                        <div class="flex items-center">
                            <p class="mr-2">{{ $token }}</p>
                        </div>
                    </div>
                @endif

                <button wire:click="createToken" type="button"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create Token') }}
                </button>
                <button wire:click="deleteToken"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Delete Token') }}
                </button>
            </div>
        </div>
    </div>
    @livewire('sync.products')
    @livewire('sync.login')
</div>
