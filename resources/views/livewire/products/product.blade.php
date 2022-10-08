<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <div class="">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>
    <div wire:loading.delay>
         <div class="d-flex justify-content-center">
        <x-loading />
    </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th>
                {{ __('Code') }}
            </x-table.th>
            <x-table.th>
                {{ __('Image') }}
            </x-table.th>
            <x-table.th>
                {{ __('Name') }}
            </x-table.th>
            <x-table.th>
                {{ __('Quantity') }}
            </x-table.th>
            <x-table.th>
                {{ __('Price') }}
            </x-table.th>
            <x-table.th>
                {{ __('Cost') }}
            </x-table.th>
            <x-table.th>
                {{ __('Category') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
            </tr>
        </x-slot>
        <x-table.tbody>
            @forelse($products as $product)
                <x-table.tr>
                    <x-table.td>
                        <input type="checkbox" value="{{ $product->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $product->product_code }}
                    </x-table.td>
                    <x-table.td>
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-full">
                    </x-table.td>
                    <x-table.td>
                        {{ $product->product_name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $product->product_quantity }}
                    </x-table.td>
                    <x-table.td>
                        {{ $product->product_cost }}
                    </x-table.td>
                    <x-table.td>
                        {{ $product->product_price }}
                    </x-table.td>
                    <x-table.td>
                        {{ $product->category->category_name }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-center">
                            <button type="button" wire:click="showModal({{ $product->id }})"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Show') }}
                            </button>
                            <button type="button" wire:click="editModal({{ $product->id }})"
                                class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-2 px-5 rounded">
                                {{ __('Edit') }} <i class="bi bi-pencil"></i>
                            </button>

                            <button type="button" wire:click="confirm('delete', {{ $product->id }})"
                                class="block uppercase mx-auto shadow bg-red-800 hover:bg-red-700 focus:shadow-outline focus:outline-none text-white text-xs py-2 px-5 rounded">
                                {{ __('Delete') }} <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10" class="text-center">
                        {{ __('No entries found.') }}
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $products->links() }}
        </div>
    </div>

    <!-- Show Modal -->
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Product') }}
        </x-slot>

        <x-slot name="content">
            <x-table>
                <x-slot name="thead">
                    <x-table.th>#</x-table.th>
                    <x-table.th>
                        {{ __('Code') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Image') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Name') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Quantity') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Price') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Cost') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Category') }}
                    </x-table.th>
                </x-slot>
                <x-table.tbody>
                    <x-table.tr>
                        <x-table.td>
                            <input type="text" wire:model="product.product_id"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.product_code"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <img src="" alt="Product Image" class="img-fluid img-thumbnail mb-2">
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.product_name"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.product_quantity"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.product_price"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.product_cost"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                        <x-table.td>
                            <input type="text" wire:model="product.category_id"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                readonly>
                        </x-table.td>
                    </x-table.tr>
                </x-table.tbody>
            </x-table>

            <x-primary-button wire:click="$toggle('showModal')">
                {{ __('Close') }}
            </x-primary-button>

        </x-slot>

    </x-modal>
    <!-- End Show Modal -->

    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Product') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="create">
                <div>
                    <div class="flex flex-wrap -mx-1">
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_code">{{ __('Product Code') }}</label>
                            <input type="text" wire:model="product.product_code"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                id="product_code" placeholder="{{ __('Enter Product Code') }}">
                            <x-input-error :messages="$errors->get('product.product_code')" for="product.product_code" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_name">{{ __('Product Name') }}</label>
                            <input type="text" wire:model="product.product_name"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                id="product_name" placeholder="{{ __('Enter Product Name') }}">
                            <x-input-error :messages="$errors->get('product.product_name')" for="product.product_name" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_quantity">{{ __('Product Quantity') }}</label>
                            <input type="text" wire:model="product.product_quantity"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                id="product_quantity" placeholder="{{ __('Enter Product Quantity') }}">
                            <x-input-error :messages="$errors->get('product.product_quantity')" for="product.product_quantity" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_price">{{ __('Product Price') }}</label>
                            <input type="text" wire:model="product.product_price"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                id="product_price" placeholder="{{ __('Enter Product Price') }}">
                            <x-input-error :messages="$errors->get('product.product_price')" for="product.product_price" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_cost">{{ __('Product Cost') }}</label>
                            <input type="text" wire:model="product.product_cost"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                id="product_cost" placeholder="{{ __('Enter Product Cost') }}">
                            <x-input-error :messages="$errors->get('product.product_cost')" for="product.product_cost" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="category_id">{{ __('Category') }}</label>
                            <x-select-list class="block bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500" id="vendor_id" name="vendor_id"
                    wire:model="product.category_id" :options="$this->listsForFields['categories']" />
                            <x-input-error :messages="$errors->get('product.category_id')" for="product.category_id" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <label for="product_stock_alert">{{ __('Alert Quantity') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model="product.product_stock_alert" name="product_stock_alert"
                                required
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                min="0" max="100">
                            <x-input-error :messages="$errors->get('product.product_stock_alert')" for="product.product_stock_alert" class="mt-2" />
                        </div>
                    </div>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        {{ __('More details') }}
                                    </button>
                                </h2>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="flex flex-wrap -mx-1">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_order_tax">{{ __('Tax (%)') }}</label>
                                                <input type="number" wire:model="product.product_order_tax"
                                                    name="product_order_tax"
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                                    min="1">
                                                <x-input-error :messages="$errors->get('product.product_order_tax')" for="product.product_order_tax"
                                                    class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_tax_type">{{ __('Tax type') }}</label>
                                                <select
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                                    wire:model="product.product_tax_type" name="product_tax_type">
                                                    <option value="" selected disabled>
                                                        {{ __('Select Tax
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Type') }}
                                                    </option>
                                                    <option value="1">{{ __('Exclusive') }}</option>
                                                    <option value="2">{{ __('Inclusive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_unit">{{ __('Unit') }} <i
                                                        class="bi bi-question-circle-fill text-info"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="This text will be placed after Product Quantity."></i>
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" wire:model="product.product_unit" name="product_unit"
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                                    required>
                                                <x-input-error :messages="$errors->get('product.product_unit')" for="product.product_unit"
                                                    class="mt-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="barcode_symbology">{{ __('Barcode Symbology') }}
                                            <span class="text-red-500">*</span></label>
                                        <select wire:model="product.barcode_symbology"
                                            class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                            name="product_barcode_symbology" id="barcode_symbology" required>
                                            <option value="C128" selected>Code 128</option>
                                            <option value="C39">Code 39</option>
                                            <option value="UPCA">UPC-A</option>
                                            <option value="UPCE">UPC-E</option>
                                            <option value="EAN13">EAN-13</option>
                                            <option value="EAN8">EAN-8</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="product_note">{{ __('Note') }}</label>
                                        <textarea wire:model="product.product_note" name="product_note"
                                            class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                        <div class="mb-4">
                            <label for="image">{{ __('Product Images') }} <i
                                    class="bi bi-question-circle-fill text-info" data-toggle="tooltip"
                                    data-placement="top"
                                    title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                            <div class="dropzone d-flex flex-wrap align-items-center justify-content-center"
                                id="document-dropzone">
                                <div class="dz-message" data-dz-message>
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button wire:click="create">
                            {{ __('Create') }}
                        </x-primary-button>
                        <x-primary-button wire:click="$toggle('createModal')">
                            {{ __('Close') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->

    <!-- Edit Modal -->
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Product') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="update">
                <div class="flex flex-wrap -mx-1">
                    <div class="lg:w-1/2 sm:w-1/2 px-2">
                        <div class="mb-4">
                            <label for="product_name" autofocus>{{ __('Product Name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="product.product_name" name="product_name"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                name="product_name" required>
                            <x-input-error :messages="$errors->get('product.product_name')" for="product.product_name" class="mt-2" />
                        </div>
                    </div>
                    <div class="lg:w-1/2 sm:w-1/2 px-2">
                        <div class="mb-4">
                            <label for="product_code">{{ __('Code') }} <span class="text-danger">*</span></label>
                            <input type="text" required wire:model="product.product_code" name="product_code"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                            <x-input-error :messages="$errors->get('product.product_code')" for="product.product_code" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-1">
                    <div class="w-full px-4">
                        <div class="mb-4">
                            <label for="category_id">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <x-select-list class="block bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500" id="vendor_id" name="vendor_id"
                    wire:model="product.category_id" :options="$this->listsForFields['categories']" />
                        </div>
                    </div>


                    <div class="flex flex-wrap -mx-1">
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <div class="mb-4">
                                <label for="product_cost">{{ __('Cost') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" wire:model="product.product_cost" name="product_cost"
                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                    min="0" name="product_cost" required>
                                <x-input-error :messages="$errors->get('product.product_cost')" for="product.product_cost" class="mt-2" />
                            </div>
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <div class="mb-4">
                                <label for="product_price">{{ __('Price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" wire:model="product.product_price" name="product_price"
                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                    min="0" name="product_price" required>
                                <x-input-error :messages="$errors->get('product.product_price')" for="product.product_price" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-1">
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <div class="mb-4">
                                <label for="product_quantity">{{ __('Quantity') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" wire:model="product.product_quantity" name="product_quantity"
                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                    required min="1">
                                <x-input-error :messages="$errors->get('product.product_quantity')" for="product.product_quantity" class="mt-2" />
                            </div>
                        </div>
                        <div class="lg:w-1/2 sm:w-1/2 px-2">
                            <div class="mb-4">
                                <label for="product_stock_alert">{{ __('Alert Quantity') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" wire:model="product.product_stock_alert" name="product_stock_alert"
                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                    required min="0">
                                <x-input-error :messages="$errors->get('product.product_stock_alert')" for="product.product_stock_alert" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        {{ __('More details') }}
                                    </button>
                                </h2>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="flex flex-wrap -mx-1">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_order_tax">{{ __('Tax') }} (%)</label>
                                                <input type="number" wire:model="product.product_order_tax"
                                                    name="product_order_tax" min="0" max="100"
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                                                <x-input-error :messages="$errors->get('product.product_order_tax')" for="product.product_order_tax"
                                                    class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_tax_type">{{ __('Tax type') }}</label>
                                                <select wire:model="product.product_tax_type" name="product_tax_type"
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                                                    <option value="inclusive">{{ __('Inclusive') }}</option>
                                                    <option value="exclusive">{{ __('Exclusive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label for="product_unit">{{ __('Unit') }} <i
                                                        class="bi bi-question-circle-fill text-info"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="This text will be placed after Product Quantity."></i>
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" wire:model="product.product_unit" name="product_unit"
                                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="barcode_symbology">{{ __('Barcode Symbology') }} <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="product.barcode_symbology" name="barcode_symbology"
                                            class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                            required>
                                            <option selected value="C128">Code 128</option>
                                            <option value="C39">Code 39</option>
                                            <option value="UPCA">UPC-A</option>
                                            <option value="UPCE">UPC-E</option>
                                            <option value="EAN13">EAN-13</option>
                                            <option value="EAN8">EAN-8</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_note">{{ __('Note') }}</label>
                                        <textarea rows="4" wire:model="product.product_note" name="product_note" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                        <div class="mb-4">
                            <label for="image">{{ __('Product Images') }} <i
                                    class="bi bi-question-circle-fill text-info" data-toggle="tooltip"
                                    data-placement="top"
                                    title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                            <div class="dropzone d-flex flex-wrap align-items-center justify-content-center"
                                id="document-dropzone">
                                <div class="dz-message" data-dz-message>
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button wire:click="update">
                            {{ __('Update') }}
                        </x-primary-button>
                        <x-primary-button wire:click="$toggle('editModal')">
                            {{ __('Close') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Edit Modal -->
    
</div>

@push('third_party_scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endpush
@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function() {
        window.livewire.on('deleteModal', productId => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('delete', productId)
                }
            })
        })
    })
</script>
@endpush

