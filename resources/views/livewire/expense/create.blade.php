<div>
    <x-modal wire:model="createExpense">
        <x-slot name="title">
            {{ __('Create Expense') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit.prevent="create">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="expense.reference" :value="__('Reference')" />
                        <x-input wire:model="expense.reference" id="expense.reference" class="block mt-1 w-full"
                            type="text" />
                        <x-input-error :messages="$errors->get('expense.reference')" class="mt-2" />
                    </div>
                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="expense.date" :value="__('Date')" />
                        <x-input-date wire:model.defer="expense.date" name="date" label="Date"  />
                        <x-input-error :messages="$errors->get('expense.date')" class="mt-2" />
                    </div>

                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="expense.category_id" :value="__('Expense Category')" />
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="category_id" name="category_id" wire:model="expense.category_id" :options="$this->listsForFields['expensecategories']" />
                    </div>
                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="expense.amount" :value="__('Amount')" required />
                        <x-input wire:model="expense.amount" id="expense.amount" class="block mt-1 w-full"
                            type="number" />
                        <x-input-error :messages="$errors->get('expense.amount')" class="mt-2" />
                    </div>
                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="expense.warehouse_id" :value="__('Warehouse')" />
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="warehouse_id" name="warehouse_id" wire:model="expense.warehouse_id" :options="$this->listsForFields['warehouses']" />
                    </div>
                    <div class="w-full px-3">
                        <x-label for="expense.details" :value="__('Description')" />
                        <textarea class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" rows="2"
                            wire:model="expense.details" id="expense.details"></textarea>
                    </div>
                </div>
                <div class="w-full flex justify-start px-3">
                    <x-button primary wire:click="create" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>