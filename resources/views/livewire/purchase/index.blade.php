<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <div class="my-2 my-md-0">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th class="pr-0 w-8">
                <input type="checkbox" wire:model="selectPage" />
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('reference')" :direction="$sorts['reference'] ?? null">
                {{ __('Reference') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('date')" :direction="$sorts['date'] ?? null">
                {{ __('Date') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('supplier_id')" :direction="$sorts['supplier_id'] ?? null">
                {{ __('Supplier') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('email')" :direction="$sorts['email'] ?? null">
                {{ __('Total') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>

        </x-slot>
        <x-table.tbody>
            @forelse ($purchases as $purchase)
                <x-table.tr>
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $purchase->id }}" wire:model="selected" />
                    </x-table.td>
                    <x-table.td>
                        {{ $purchase->reference }}
                    </x-table.td>
                    <x-table.td>
                        {{ $purchase->date }}
                    </x-table.td>
                    <x-table.td>
                        {{ $purchase->supplier->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $purchase->status }}
                    </x-table.td>
                    <x-table.td>
                        {{ $purchase->total }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex flex-wrap justify-start space-x-2">

                            @can('access_purchase_payments')
                                <x-button primary href="{{ route('purchase-payments.index', $purchase->id) }}">
                                    {{ __('Show Payments') }}
                                </x-button>
                            @endcan

                            @can('access_purchase_payments')
                                @if ($purchase->due_amount > 0)
                                    <x-button info href="{{ route('purchase-payments.create', $purchase->id) }}">
                                        {{ __('Add Payment') }}
                                    </x-button>
                                @endif
                            @endcan

                            @can('show_purchases')
                                <x-button primary wire:click="showModal({{ $purchase->id }})">
                                    <i class="fas fa-eye"></i>
                                </x-button>
                            @endcan

                            @can('edit_purchases')
                                <x-button primary href="{{ route('purchases.edit', $purchase->id) }}">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                            @endcan

                            @can('delete_purchases')
                                <x-button danger class="ml-2" type="button"
                                    wire:click="confirmPurchaseDeletion({{ $purchase->id }})">
                                    <i class="fas fa-trash"></i>
                                </x-button>
                            @endcan

                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="7">
                        <div class="flex justify-center items-center">
                            <i class="fas fa-box-open text-4xl text-gray-400"></i>
                            {{ __('No results found') }}
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $purchases->links() }}
    </div>


    {{-- Show Purchase --}}
    @if($purchase)
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Purchase') }} - {{ __('Reference') }}: <strong>{{ $purchase->reference }}</strong>
            <div class="float-right">
                <x-button secondary href="{{ route('purchases.pdf', $purchase->id) }}">
                    <i class="fas fa-file-pdf"></i>
                    {{ __('PDF') }}
                </x-button>
                <x-button secondary href="{{ route('purchases.pdf', $purchase->id) }}">
                    <i class="fas fa-print"></i>
                    {{ __('Save') }}
                </x-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="px-2 mx-auto py-4">
                <div class="flex flex-row">
                    <div class="w-full">
                        <div class="flex flex-row mb-4">
                            <div class="md:w-1/3 mb-3 md:mb-0">
                                <h5 class="mb-2 border-bottom pb-2">{{ __('Company Info') }}:</h5>
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                                <div>{{ __('Email') }}: {{ settings()->company_email }}</div>
                                <div>{{ __('Phone') }}: {{ settings()->company_phone }}</div>
                            </div>

                            <div class="md:w-1/3 mb-3 md:mb-0">
                                <h5 class="mb-2 border-bottom pb-2">{{ __('Supplier Info') }}:</h5>
                                <div><strong>{{ $purchase->supplier->name }}</strong></div>
                                <div>{{ $purchase->supplier->address }}</div>
                                <div>{{ __('Email') }}: {{ $purchase->supplier->email }}</div>
                                <div>{{ __('Phone') }}: {{ $purchase->supplier->phone }}</div>
                            </div>

                            <div class="md:w-1/3 mb-3 md:mb-0">
                                <h5 class="mb-2 border-bottom pb-2">{{ __('Invoice Info') }}:</h5>
                                <div>{{ __('Invoice') }}: <strong>INV/{{ $purchase->reference }}</strong></div>
                                <div>{{ __('Date') }}:
                                    {{ \Carbon\Carbon::parse($purchase->date)->format('d M, Y') }}</div>
                                <div>
                                    {{ __('Status') }}: <strong>{{ $purchase->status }}</strong>
                                </div>
                                <div>
                                    {{ __('Payment Status') }}: <strong>{{ $purchase->payment_status }}</strong>
                                </div>
                            </div>

                        </div>

                        <div>
                            <x-table>
                                <x-slot name="thead">
                                    <x-table.th>{{ __('Product') }}</x-table.th>
                                    <x-table.th>{{ __('Quantity') }}</x-table.th>
                                    <x-table.th>{{ __('Unit Cost') }}</x-table.th>
                                    <x-table.th>{{ __('Tax') }}</x-table.th>
                                    <x-table.th>{{ __('Discount') }}</x-table.th>
                                    <x-table.th>{{ __('Tax') }}</x-table.th>
                                    <x-table.th>{{ __('Sub Total') }}</x-table.th>
                                </x-slot>
                                <x-table.tbody>
                                    @foreach ($purchase->purchaseDetails as $item)
                                        <x-table.tr>
                                            <x-table.td class="align-middle">
                                                {{ $item->name }} <br>
                                                <x-badge primary>
                                                    {{ $item->code }}
                                                </x-badge>
                                            </x-table.td>

                                            <x-table.td class="align-middle">
                                                {{ format_currency($item->unit_price) }}
                                            </x-table.td>

                                            <x-table.td class="align-middle">
                                                {{ $item->quantity }}
                                            </x-table.td>

                                            <x-table.td class="align-middle">
                                                {{ format_currency($item->product_discount_amount) }}
                                            </x-table.td>

                                            <x-table.td class="align-middle">
                                                {{ format_currency($item->product_tax_amount) }}
                                            </x-table.td>

                                            <x-table.td class="align-middle">
                                                {{ format_currency($item->sub_total) }}
                                            </x-table.td>
                                        </x-table.tr>
                                    @endforeach
                                </x-table.tbody>
                            </x-table>
                        </div>
                        <div class="row">
                            <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0 col-sm-5 ml-md-auto">
                                <x-table-responsive>
                                    <x-table.tr>
                                        <x-table.heading class="left">
                                            <strong>{{ __('Discount') }}
                                                ({{ $purchase->discount_percentage }}%)</strong>
                                        </x-table.heading>
                                        <x-table.td class="right">
                                            {{ format_currency($purchase->discount_amount) }}</x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.heading class="left">
                                            <strong>{{ __('Tax') }} ({{ $purchase->tax_percentage }}%)</strong>
                                        </x-table.heading>
                                        <x-table.td class="right">
                                            {{ format_currency($purchase->tax_amount) }}
                                        </x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.heading class="left">
                                            <strong>{{ __('Shipping') }}</strong>
                                        </x-table.heading>
                                        <x-table.td class="right">
                                            {{ format_currency($purchase->shipping_amount) }}</x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.heading class="left">
                                            <strong>{{ __('Grand Total') }}</strong>
                                        </x-table.heading>
                                        <x-table.td class="right">
                                            <strong>{{ format_currency($purchase->total_amount) }}</strong>
                                        </x-table.td>
                                    </x-table.tr>
                                </x-table-responsive>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal>
    @endif

</div>
