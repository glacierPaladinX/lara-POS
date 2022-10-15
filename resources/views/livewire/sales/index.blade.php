<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="$toggle('showDeleteModal')" wire:loading.attr="disabled">
                    <i class="fas fa-trash"></i>
                </x-button>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <div class="my-2 my-md-0">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>
    <div wire:loading.delay class="flex justify-center">
        <x-loading />
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th class="pr-0 w-8">
                <input type="checkbox" wire:model="selectPage" />
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('date')" :direction="$sorts['date'] ?? null">
                {{ __('Date') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('customer_id')" :direction="$sorts['customer_id'] ?? null">
                {{ __('Customer') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('payment_status')" :direction="$sorts['payment_status'] ?? null">
                {{ __('Payment status') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('total')" :direction="$sorts['total'] ?? null">
                {{ __('Total') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>

        <x-table.tbody>
            @forelse ($sales as $sale)
                <x-table.tr wire:loading.class.delay="opacity-50">
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $sale->id }}" wire:model="selected" />
                    </x-table.td>
                    <x-table.td>
                        {{ $sale->date }}
                    </x-table.td>
                    <x-table.td>
                        {{ $sale->customer->name }}
                    </x-table.td>
                    <x-table.td>
                        @if ($sale->payment_status == 'Partial')
                            <x-badge warning>
                                {{ $sale->payment_status }}
                            </x-badge>
                        @elseif ($sale->payment_status == 'Paid')
                            <x-badge success>
                                {{ $sale->payment_status }}
                            </x-badge>
                        @else
                            <x-badge danger>
                                {{ $sale->payment_status }}
                            </x-badge>
                        @endif
                    </x-table.td>

                    <x-table.td>
                        {{ $sale->total_amount }}
                    </x-table.td>

                    <x-table.td>
                        @if ($sale->status == 'Pending')
                            <x-badge warning>
                                {{ $sale->status }}
                            </x-badge>
                        @elseif ($sale->status == 'Shipped')
                            <x-badge success>
                                {{ $sale->status }}
                            </x-badge>
                        @else
                            <x-badge danger>
                                {{ $sale->status }}
                            </x-badge>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button info type="button" wire:click="showModal({{ $sale->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>

                            @can('edit_sales')
                                <x-button href="{{ route('sales.edit', $sale) }}" primary wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                            @endcan

                            @can('delete_sales')
                                <x-button href="{{ route('sales.destroy', $sale) }}" danger type="button"
                                    wire:click="confirm('delete', {{ $sale->id }})" wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                </x-button>
                            @endcan

                            <x-button target="_blank" href="{{ route('sales.pos.pdf', $sale->id) }}" warning
                                wire:loading.attr="disabled">
                                <i class="fas fa-print"></i>
                            </x-button>

                            @can('access_sale_payments')
                                <x-button href="{{ route('sale-payments.index', $sale->id) }}" success
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-money-bill-wave"></i>
                                </x-button>
                            @endcan
                            @can('access_sale_payments')
                                @if ($sale->due_amount > 0)
                                    <x-button href="{{ route('sale-payments.create', $sale->id) }}" success
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </x-button>
                                @endif
                            @endcan
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td>
                        <div class="flex justify-center items-center">
                            <span class="text-gray-400 dark:text-gray-300">{{ __('No results found') }}</span>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="px-6 py-3">
        {{ $sales->links() }}
    </div>

    <x-modal wire:model="create">
        <x-slot name="title">
            {{ __('Create Sale') }}
        </x-slot>

        <x-slot name="content">
            <div class"w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
                <x-label for="date" :value="__('Date')" />
                <x-input id="date" class="block mt-1 w-full" type="date" wire:model.defer="date" />
                <x-input-error :messages="$errors->get('date')" for="date" class="mt-2" />
            </div>

            <div class"w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
                <x-label for="customer_id" :value="__('Customer')" />
                <x-select-list
                    class="block bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    id="customer_id" name="customer_id" wire:model="product.customer_id" :options="$this->listsForFields['custmers']" />

                <x-input-error :messages="$errors->get('customer_id')" for="customer_id" class="mt-2" />
            </div>
        </x-slot>
    </x-modal>

    <x-modal wire:model="update">
        <x-slot name="title">
            {{ __('Update Sale') }}
        </x-slot>

        <x-slot name="content">
            <div class"w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
                <x-label for="date" :value="__('Date')" />
                <x-input id="date" class="block mt-1 w-full" type="date" wire:model.defer="date" />
                <x-input-error :messages="$errors->get('date')" for="date" class="mt-2" />
            </div>

            <div class"w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
                <x-label for="customer_id" :value="__('Customer')" />
                <x-select-list
                    class="block bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    id="customer_id" name="customer_id" wire:model="product.customer_id" :options="$this->listsForFields['custmers']" />
                <x-input-error :messages="$errors->get('customer_id')" for="customer_id" class="mt-2" />
            </div>
        </x-slot>
    </x-modal>

    {{-- Show Sale --}}
    @if ($sale)
        <x-modal wire:model="showModal">
            <x-slot name="title">
                {{ __('Show Sale') }} - {{ __('Reference') }}: <strong>{{ $sale->reference }}</strong>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 mx-auto">
                    <div class="flex flex-row">
                        <div class="w-full">
                            <div class="p-2 d-flex flex-wrap items-center">
                                <x-button secondary class="d-print-none" target="_blank"
                                    href="{{ route('sales.pdf', $sale->id) }}" class="ml-auto">
                                    <i class="fas fa-print"></i> {{ __('Print') }}
                                </x-button>
                                <x-button secondary class="d-print-none" target="_blank"
                                    href="{{ route('sales.pdf', $sale->id) }}" class="ml-2">
                                    <i class="fas fa-download"></i> {{ __('Download') }}
                                </x-button>
                                {{-- Button close modal --}}
                                <x-button secondary class="d-print-none" wire:click="$set('showModal', false)"
                                    class="ml-2">
                                    <i class="fas fa-times"></i> {{ __('Close') }}
                                </x-button>
                                </a>
                            </div>
                            <div class="p-4">
                                <div class="flex flex-row mb-4">
                                    <div class="md:w-1/3 mb-3 md:mb-0">
                                        <h5 class="mb-2 border-bottom pb-2">{{ __('Company Info') }}:</h5>
                                        <div><strong>{{ settings()->company_name }}</strong></div>
                                        <div>{{ settings()->company_address }}</div>
                                        <div>{{ __('Email') }}: {{ settings()->company_email }}</div>
                                        <div>{{ __('Phone') }}: {{ settings()->company_phone }}</div>
                                    </div>

                                    <div class="md:w-1/3 mb-3 md:mb-0">
                                        <h5 class="mb-2 border-bottom pb-2">{{ __('Customer Info') }}:</h5>
                                        <div><strong>{{ $sale->customer->name }}</strong></div>
                                        <div>{{ $sale->customer->address }}</div>
                                        <div>{{ __('Email') }}: {{ $sale->customer->email }}</div>
                                        <div>{{ __('Phone') }}: {{ $sale->customer->phone }}</div>
                                    </div>

                                    <div class="md:w-1/3 mb-3 md:mb-0">
                                        <h5 class="mb-2 border-bottom pb-2">{{ __('Invoice Info') }}:</h5>
                                        <div>{{ __('Invoice') }}: <strong>INV/{{ $sale->reference }}</strong></div>
                                        <div>{{ __('Date') }}:
                                            {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</div>
                                        <div>
                                            {{ __('Status') }}: <strong>{{ $sale->status }}</strong>
                                        </div>
                                        <div>
                                            {{ __('Payment Status') }}: <strong>{{ $sale->payment_status }}</strong>
                                        </div>
                                    </div>

                                </div>

                                <div class="">
                                    <x-table>
                                        <x-slot name="thead">
                                            <x-table.th>{{ __('Product') }}</x-table.th>
                                            <x-table.th>{{ __('Quantity') }}</x-table.th>
                                            <x-table.th>{{ __('Unit Price') }}</x-table.th>
                                            <x-table.th>{{ __('Discount') }}</x-table.th>
                                            <x-table.th>{{ __('Tax') }}</x-table.th>
                                            <x-table.th>{{ __('Subtotal') }}</x-table.th>
                                        </x-slot>

                                        <x-table.tbody>
                                            @foreach ($sale->saleDetails as $item)
                                                <x-table.tr>
                                                    <x-table.td>
                                                        {{ $item->name }} <br>
                                                        <x-badge success>
                                                            {{ $item->code }}
                                                        </x-badge>
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ format_currency($item->unit_price) }}
                                                    </x-table.td>

                                                    <x-table.td>
                                                        {{ $item->quantity }}
                                                    </x-table.td>

                                                    <x-table.td>
                                                        {{ format_currency($item->product_discount_amount) }}
                                                    </x-table.td>

                                                    <x-table.td>
                                                        {{ format_currency($item->product_tax_amount) }}
                                                    </x-table.td>

                                                    <x-table.td>
                                                        {{ format_currency($item->sub_total) }}
                                                    </x-table.td>
                                                </x-table.tr>
                                            @endforeach
                                        </x-table.tbody>
                                    </x-table>
                                </div>
                                <div class="flex flex-row">
                                    <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0 col-sm-5 ml-md-auto">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="left"><strong>{{ __('Discount') }}
                                                            ({{ $sale->discount_percentage }}%)</strong></td>
                                                    <td class="right">{{ format_currency($sale->discount_amount) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>{{ __('Tax') }}
                                                            ({{ $sale->tax_percentage }}%)</strong></td>
                                                    <td class="right">{{ format_currency($sale->tax_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>{{ __('Shipping') }}</strong></td>
                                                    <td class="right">{{ format_currency($sale->shipping_amount) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>{{ __('Grand Total') }}</strong></td>
                                                    <td class="right">
                                                        <strong>{{ format_currency($sale->total_amount) }}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-modal>
    @endif
    {{-- End Show Sale --}}

    {{-- Import modal --}}

    <x-modal wire:model="importModal">
        <x-slot name="title">
            {{ __('Import Excel') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="import">
                <div class="space-y-4">
                    <div class="mt-4">
                        <x-label for="import" :value="__('Import')" />
                        <x-input id="import" class="block mt-1 w-full" type="file" name="import"
                            wire:model.defer="import_file" />
                        <x-input-error :messages="$errors->get('import')" for="import" class="mt-2" />
                    </div>

                    <div class="w-full flex justify-end">
                        <x-button primary wire:click="import" wire:loading.attr="disabled">
                            {{ __('Import') }}
                        </x-button>
                        <x-button primary type="button" wire:click="$set('importModal', false)"
                            wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>

    {{-- End Import modal --}}

</div>

@push('page_scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('deleteModal', saleId => {
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
                        window.livewire.emit('delete', saleId)
                    }
                })
            })
        })
    </script>
@endpush
