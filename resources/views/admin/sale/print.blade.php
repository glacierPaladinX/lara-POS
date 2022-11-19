<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('Sale Details')}}</title>
    <link rel="stylesheet" href="{{ public_path('print/bootstrap.min.css') }}">
</head>
<body>
<div class="px-4 mx-auto">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="180" src="{{ public_path('images/logo-dark.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px;">
                    <span>{{__('Reference')}}::</span> <strong>{{ $sale->reference }}</strong>
                </h4>
            </div>
            <div class="card">
                <div class="p-4">
                    <div class="row mb-4">
                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Company Info:</h4>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>{{__('Email')}}: {{ settings()->company_email }}</div>
                            <div>{{__('Phone')}}: {{ settings()->company_phone }}</div>
                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Customer Info:</h4>
                            <div><strong>{{ $customer->name }}</strong></div>
                            <div>{{ $customer->address }}</div>
                            <div>{{__('Email')}}: {{ $customer->email }}</div>
                            <div>{{__('Phone')}}: {{ $customer->phone }}</div>
                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Invoice Info:</h4>
                            <div>{{__('Invoice')}}: <strong>INV/{{ $sale->reference }}</strong></div>
                            <div>{{__('Date')}}: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</div>
                            <div>
                                Status: <strong>{{ $sale->status }}</strong>
                            </div>
                            <div>
                                Payment Status: <strong>{{ $sale->payment_status }}</strong>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive-sm" style="margin-top: 30px;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="align-middle">Product</th>
                                <th class="align-middle">{{__('Net Unit Price')}}</th>
                                <th class="align-middle">{{__('Quantity')}}</th>
                                <th class="align-middle">{{__('Discount')}}</th>
                                <th class="align-middle">{{__('Tax')}}</th>
                                <th class="align-middle">{{__('Sub Total')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleDetails as $item)
                                <tr>
                                    <td class="align-middle">
                                        {{ $item->name }} <br>
                                        <span class="badge badge-success">
                                                {{ $item->code }}
                                            </span>
                                    </td>

                                    <td class="align-middle">{{ format_currency($item->unit_price) }}</td>

                                    <td class="align-middle">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_discount_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_tax_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->sub_total) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="left"><strong>{{__('Discount')}} ({{ $sale->discount_percentage }}%)</strong></td>
                                    <td class="right">{{ format_currency($sale->discount_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{__('Tax')}} ({{ $sale->tax_percentage }}%)</strong></td>
                                    <td class="right">{{ format_currency($sale->tax_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{__('Shipping')}}</strong></td>
                                    <td class="right">{{ format_currency($sale->shipping_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{__('Grand Total')}}</strong></td>
                                    <td class="right"><strong>{{ format_currency($sale->total_amount) }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            <p style="font-style: italic;text-align: center">{{ settings()->company_name }} &copy; {{ date('Y') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
