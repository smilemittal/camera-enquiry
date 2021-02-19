<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
<table class="table table-bordered table-striped" style="border-collapse: collapse; width: 100%" >


    <tbody>
        @if(!empty($enquiry))
            <tr><th style="border: 1px solid #000;text-align: center; width: 50%;">{{translate('Customer Name:')}}</th><td style="border: 1px solid #000;text-align: center; width: 50%;">{{ $enquiry->first_name.''.$enquiry->last_name }}</td></tr>
            <tr><th style="border: 1px solid #000;text-align: center;width: 50%;">{{translate('Email:')}}'}}</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->email }}</td></tr>
            <tr><th style="border: 1px solid #000;text-align: center;width: 50%;">{{translate('Company:')}}</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->company }}</td></tr>
            <tr><th style="border: 1px solid #000;text-align: center;width: 50%;">{{translate('Mobile:')}}</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->mobile_no }}</td></tr>
        @endif

        @php
            $total_price = 0;
            $total_qty = 0;

        @endphp
        @foreach($products as $product_type => $product)
            @if(!empty($quantities[$product_type]['total'] ) && $quantities[$product_type]['total'] != 0)

                <tr><th colspan="4" style="border: 1px solid #000; text-align: center;">{{translate('Chosen ').' '.ucfirst($product_type) }}</td></tr>
                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('Model')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Quantity')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Price for one')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Summary price for all')}}</th></tr>

                @php
                $quantity_total = 0;
                $price_total = 0;
                @endphp
                @foreach($product as $no => $attribute_values)
                <tr>
                    <td style="border: 1px solid #000;text-align: center;">{{ $models[$product_type][$no]->name }}</td>
                    <td style="border: 1px solid #000;text-align: center;">
                        @php
                        if(!empty($quantities[$product_type][$no])){
                            $quantity_total += (int)$quantities[$product_type][$no]['total_qty'];
                            $price_total += $models[$product_type][$no]->price * (int)$quantities[$product_type][$no]['total_qty'];
                            $total_price += $models[$product_type][$no]->price * (int)$quantities[$product_type][$no]['total_qty'];
                            $total_qty += (int)$quantities[$product_type][$no]['total_qty'];
                        }
                        @endphp
                        @if(!empty($quantities[$product_type][$no]['total_qty']))
                            {{ (int)$quantities[$product_type][$no]['total_qty'] }}
                        @endif
                    </td>
                    <td style="border: 1px solid #000;text-align: center;">
                        {{$models[$product_type][$no]->price}}
                    </td>
                    <td style="border: 1px solid #000;text-align: center;">
                        {{$models[$product_type][$no]->price * (int)$quantities[$product_type][$no]['total_qty'] }}
                    </td>
                </tr>
                @endforeach
                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('Total')}} {{ ucfirst($product_type).'s'}}</th><td  style="border: 1px solid #000;text-align: center;">{{ $quantity_total }}</td>
                    <td  style="border: 1px solid #000;text-align: center;"></td>
                    <td  style="border: 1px solid #000;text-align: center;">{{ $price_total }}</td></tr>
            @endif
        @endforeach
        <tr><th style="border: 1px solid #000;text-align: center;" colspan="3">{{translate('Summary Price for all products')}}</th>
        <td  style="border: 1px solid #000;text-align: center;">{{ $total_price }}</td></tr>
    </tbody>
</table>
