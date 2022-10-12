<div>
    <div class="row">
        <form wire:submit.prevent="generateReport">
            <div class="flex flex-wrap -mx-1">
                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-4">
                    <div class="mb-4">
                        <x-label for="start_date" :value="__('Start Date')" required />
                        <input wire:model.defer="start_date" type="date"
                            class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                            name="start_date">
                        @error('start_date')
                            <span class="text-danger mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-4">
                    <div class="mb-4">
                        <x-label for="end_date" :value="__('End Date')" required />
                        <input wire:model.defer="end_date" type="date"
                            class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                            name="end_date">
                        @error('end_date')
                            <span class="text-danger mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-4 mb-0">
                <button type="submit"
                    class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">
                    <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm"
                        role="status" aria-hidden="true"></span>
                    <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                    {{ __('Filter Report') }}
                </button>
            </div>
        </form>
    </div>

    <div class="row">
        {{-- Sales --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-receipt font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($sales_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small ">{{ $total_sales }} {{ __('Sales') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Sale Returns --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-arrow-return-left font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($sale_returns_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ $total_sale_returns }}
                            {{ __('Sale Returns') }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Profit --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-trophy font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($profit_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ __('Profit') }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Purchases --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-bag font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($purchases_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ $total_purchases }}
                            {{ __('Purchases') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Purchase Returns --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-arrow-return-right font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($purchase_returns_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ $total_purchase_returns }}
                            {{ __('Purchase Returns') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Expenses --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-wallet2 font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($expenses_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ __('Expenses') }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Payments Received --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-cash-stack font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($payments_received_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ __('Payments Received') }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Payments Sent --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-cash-stack font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($payments_sent_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">{{ __('Payments Sent') }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Payments Net --}}
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="bi bi-cash-stack font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ format_currency($payments_net_amount) }}</div>
                        <div class="text-uppercase font-weight-bold small">Payments Net</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>