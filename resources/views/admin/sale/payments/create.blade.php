@extends('layouts.app')

@section('title', 'Create Payment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.show', $sale) }}">{{ $sale->reference }}</a></li>
        <li class="breadcrumb-item active">Add Payment</li>
    </ol>
@endsection

@section('content')
    <div class="px-4 mx-auto">
        <form id="payment-form" action="{{ route('sale-payments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="w-full px-4">
                    @include('utils.alerts')
                    <div class="mb-4">
                        <button class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">Create Payment <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="w-full px-4">
                    <div class="card">
                        <div class="p-4">
                            <div class="flex flex-wrap -mx-1">
                                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-4">
                                    <div class="mb-4">
                                        <label for="reference">{{__('Reference')}} <span class="text-red-500">*</span></label>
                                        <input type="text" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="reference" required readonly value="INV/{{ $sale->reference }}">
                                    </div>
                                </div>
                                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-4">
                                    <div class="mb-4">
                                        <label for="date">{{__('Date')}} <span class="text-red-500">*</span></label>
                                        <input type="date" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="date" required value="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="due_amount">{{__('Due Amount')}} <span class="text-red-500">*</span></label>
                                        <input type="text" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="due_amount" required value="{{ format_currency($sale->due_amount) }}" readonly>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="amount">{{__('Amount')}} <span class="text-red-500">*</span></label>
                                        <div class="input-group">
                                            <input id="amount" type="text" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="amount" required value="{{ old('amount') }}">
                                            <div class="input-group-append">
                                                <button id="getTotalAmount" class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="from-group">
                                        <div class="mb-4">
                                            <label for="payment_method">{{__('Payment Method')}} <span class="text-red-500">*</span></label>
                                            <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="note">Note</label>
                                <textarea class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" rows="4" name="note">{{ old('note') }}</textarea>
                            </div>

                            <input type="hidden" value="{{ $sale->id }}" name="sale_id">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#amount').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#getTotalAmount').click(function () {
                $('#amount').maskMoney('mask', {{ $sale->due_amount }});
            });

            $('#payment-form').submit(function () {
                var amount = $('#amount').maskMoney('unmasked')[0];
                $('#amount').val(amount);
            });
        });
    </script>
@endpush

