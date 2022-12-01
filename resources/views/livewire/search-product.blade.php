<div class="relative">
    <div class="mb-3 px-2">
        <div class="mb-2 w-full">
            <input wire:keydown.escape="resetQuery" wire:model.debounce.500ms="query" type="search" autofocus
                class="block w-full shadow-sm focus:ring-indigo-500 active:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                placeholder="{{ __('Type product name or code....') }}">
        </div>
        <div class="flex flex-wrap -mx-2 mb-3">
            <div class="md:w-1/3 px-2">
                <x-label for="category" :value="__('Category')" />
                <x-select-list
                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                    required id="categories" name="categories" wire:model="category_id" :options="$this->listsForFields['categories']" />
            </div>
            <div class="md:w-1/3 px-2">
                <x-label for="warehouse" :value="__('Warehouse')" />
                <x-select-list
                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                    required id="warehouses" name="warehouses" wire:model="warehouse_id" :options="$this->listsForFields['warehouses']" />
            </div>
            <div class="md:w-1/3 px-2">
                <x-label for="showCount" :value="__('Product per page')" />
                <select wire:model="showCount"
                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1">
                    <option value="9">9</option>
                    <option value="15">15</option>
                    <option value="21">21</option>
                    <option value="30">30</option>
                    <option value="">{{ __('All Products') }}</option>
                </select>
            </div>
        </div>

    </div>

    <div wire:loading.flex class="w-full px-2 absolute justify-center items-center"
        style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
        <x-loading />
    </div>

    @if (!empty($query))
        <div wire:click="resetQuery fixed w-full h-full  left-0 right-0 top-0 bottom-0 z-10">
        </div>
        @if ($search_results->isNotEmpty())
            <div class="flex flex-row relative">
                <div class="w-full grid gap-3 md:grid-cols-2 lg:grid-cols-3 px-2 mt-5 overflow-y-auto bg-white">
                    @foreach ($search_results as $result)
                        <div wire:click.prevent="selectProduct({{ $result }})" class="w-full py-10 relative pointer">
                            <div class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-white bg-blue-400 mb-3 absolute"
                                style="right:10px;top: 10px;">{{ __('Stock') }}: {{ $result->quantity }}
                            </div>
                            <div class="inline-block p-1 text-center">
                                <div class="mb-2">
                                    <h6 class="text-md text-center font-semibold mb-3 md:mb-0">{{ $result->name }}
                                    </h6>
                                </div>
                                <p class="mb-0 text-center font-bold">{{ format_currency($result->price) }}</p>
                            </div>
                            <span
                                class="block p-1 text-center font-semibold text-xs align-baseline leading-none text-white bg-green-400">
                                {{ $result->code }}
                            </span>
                        </div>
                    @endforeach
                    <ul>
                        @if ($search_results->count() >= $how_many)
                            <li
                                class="relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-grey-light no-underline w-fill text-center">
                                <a wire:click.prevent="loadMore"
                                    class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded btn-sm"
                                    href="#">
                                    {{ __('Load More') }} <i class="bi bi-arrow-down-circle"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <div class="w-full px-2">
                <div
                    class="relative px-3 py-3 mb-4 border rounded text-yellow-800 border-yellow-800 bg-yellow-400 md:mb-0">
                    <span class="inline-block align-middle mr-8">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11a1 1 0 11-2 0 1 1 0 012 0zm-1-3a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="inline-block align-middle mr-8">
                        {{ __('No product found') }}
                    </span>
                </div>
            </div>
        @endif
    @else
        <div class="w-full px-2 ">
            <div class="flex flex-row relative">
                <div class="w-full grid gap-3 md:grid-cols-2 lg:grid-cols-3 px-2 mt-5 overflow-y-auto bg-white">
                    @forelse($products as $product)
                        <div wire:click.prevent="selectProduct({{ $product }})" class="w-full py-10 relative">
                            <div class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-white bg-blue-400 mb-3 absolute"
                                style="right:10px;top: 10px;">{{ __('Stock') }}: {{ $product->quantity }}
                            </div>
                            <div class="inline-block p-1 text-center">
                                <div class="mb-2">
                                    <h6 class="text-md text-center font-semibold mb-3 md:mb-0">{{ $product->name }}
                                    </h6>
                                </div>
                                <p class="mb-0 text-center font-bold">{{ format_currency($product->price) }}</p>
                            </div>
                            <span
                                class="block p-1 text-center font-semibold text-xs align-baseline leading-none text-white bg-green-400">
                                {{ $product->code }}
                            </span>
                        </div>
                    @empty
                        <div class="w-full px-2">
                            <div
                                class="relative px-3 py-3 mb-4 border rounded text-yellow-800 border-yellow-800 bg-yellow-400 md:mb-0">
                                <span class="inline-block align-middle mr-8">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11a1 1 0 11-2 0 1 1 0 012 0zm-1-3a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span class="inline-block align-middle mr-8">
                                    {{ __('No product found') }}
                                </span>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div @class(['mt-3' => $products->hasPages()])>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
