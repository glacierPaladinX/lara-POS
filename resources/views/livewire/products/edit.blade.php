<div>
    <!-- Edit Modal -->
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Product') }} - {{ $product?->name }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="update">
                <x-validation-errors class="mb-4" :errors="$errors" />
                <div>
                    <div class="flex flex-wrap -mx-2 mb-3">
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="name" :value="__('Product Name')" required autofocus />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                wire:model="product.name" required autofocus />
                            <x-input-error :messages="$errors->get('product.name')" for="product.name" class="mt-2" />
                        </div>
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="code" :value="__('Product Code')" required />
                            <x-input id="code" class="block mt-1 w-full" type="text" name="code"
                                wire:model="product.code" disabled required />
                            <x-input-error :messages="$errors->get('product.code')" for="product.code" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2 mb-3">
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="category_id" :value="__('Category')" required />
                            <x-select2 :options="$this->categories" id="category_edit" name="category_edit"
                                wire:model="product.category_id" />
                            <x-input-error :messages="$errors->get('product.category_id')" for="category_id" class="mt-2" />
                        </div>
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="stock_alert" :value="__('Stock Alert')" required />
                            <x-input id="stock_alert" class="block mt-1 w-full" type="text" name="stock_alert"
                                wire:model="product.stock_alert" required />
                            <x-input-error :messages="$errors->get('product.stock_alert')" for="product.stock_alert" class="mt-2" />
                        </div>
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="featured" :value="__('Featured in Pos')" />
                            <x-input.checkbox id="featured" class="block mt-1 w-full" type="checkbox" name="featured"
                                wire:model.lazy="product.featured" />
                            <x-input-error :messages="$errors->get('featured')" for="featured" class="mt-2" />
                        </div>
                    </div>

                    <x-accordion title="{{ 'More Details' }}">
                        <div class="flex flex-wrap -mx-2 mb-3">
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="warehouse" :value="__('Warehouse')" />
                                <x-select2 :options="$this->warehouses" id="warehouse_id" name="warehouse_id"
                                    wire:model="product.warehouse_id" />
                                <x-input-error :messages="$errors->get('warehouse_id')" for="warehouse_id" class="mt-2" />
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="brand_id" :value="__('Brand')" />
                                <x-select2 :options="$this->brands" id="brand_edit" name="brand_edit"
                                    wire:model="product.brand_id" />
                                <x-input-error :messages="$errors->get('product.brand_id')" for="brand_id" class="mt-2" />
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="order_tax" :value="__('Tax')" />
                                <x-input id="order_tax" class="block mt-1 w-full" type="text" name="order_tax"
                                    wire:model="product.order_tax" />
                                <x-input-error :messages="$errors->get('product.order_tax')" for="product.order_tax" class="mt-2" />

                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="tax_type" :value="__('Tax type')" />
                                <select wire:model="product.tax_type" name="tax_type"
                                    class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                                    <option value="inclusive">{{ __('Inclusive') }}</option>
                                    <option value="exclusive">{{ __('Exclusive') }}</option>
                                </select>
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="unit" :value="__('Unit')" />
                                <x-input id="unit" class="block mt-1 w-full" type="text" name="unit"
                                    wire:model="product.unit" required />
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="barcode_symbology" :value="__('Barcode Symbology')" />
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
                            <div class="md:w-1/2 sm:w-full px-4 gap-2">
                                <x-label for="featured" :value="__('Favorite proudct')" />
                                <x-input.checkbox id="featured" type="checkbox" name="featured"
                                    wire:model.lazy="product.featured" />
                                <x-input-error :messages="$errors->get('featured')" for="featured" class="mt-2" />
                            </div>
                            <div class="w-full mb-2 px-4">
                                <x-label for="note" :value="__('Description')" />
                                <textarea rows="4" wire:model="product.note" name="note"
                                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                    rows="3">
                                            </textarea>
                            </div>
                        </div>
                    </x-accordion>


                    <div class="w-full px-4 my-4">
                        <x-label for="image" :value="__('Product Image')" />
                        <x-fileupload wire:model="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                        <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                    </div>

                    <div class="w-full px-4">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full text-center">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>

    <!-- End Edit Modal -->
</div>
