<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
<table class="table table-bordered table-striped" style="border-collapse: collapse; width: 100%" >


    <tbody>
        @if(!empty($enquiry))
            <tr><th style="border: 1px solid #000;text-align: center; width: 50%;">Customer Name:</th><td style="border: 1px solid #000;text-align: center; width: 50%;">{{ $enquiry->first_name.''.$enquiry->last_name }}</td></tr>
            <tr><th style="border: 1px solid #000;text-align: center;width: 50%;">Email:</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->email }}</td></tr>
            <tr><th style="border: 1px solid #000;text-align: center;width: 50%;">Company:</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->company }}</td></tr>
            <tr> <th style="border: 1px solid #000;text-align: center;width: 50%;">Mobile:</th><td style="border: 1px solid #000;text-align: center;">{{ $enquiry->mobile_no }}</td></tr>
        @endif

        @php
            $product_name = '';
            $quantity_total = 0;

        @endphp
        @foreach($products as $product_type => $product)
            @if(!empty($quantities[$product_type]['total'] ) && $quantities[$product_type]['total'] != 0)

                <tr><th style="border: 1px solid #000; text-align: center;">{{translate('Product Type')}}</th><td colspan="2" style="border: 1px solid #000; text-align: center;">     {{ ucfirst($product_type) }}</td></tr>
                <tr><th colspan="3" style="text-align: center; border: 1px solid #000;">{{translate('Product Details')}}</th></tr>
                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('S. No.')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Attributes')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Quantity')}}</th></tr>

                @php
                $i= 1;
                $quantity_total = 0;
                @endphp
                @foreach($product as $no => $attribute_values)
                <tr>
                    <td style="border: 1px solid #000;text-align: center;">{{  $i }}</td>
                    <td style="border: 1px solid #000;text-align: center;">
                        @php
                            $attributes = $attribute_values_arr = [];

                            foreach($attribute_values as $attribute_id => $attribute_value){
                                if($attribute_value != 'unimportant'){
                                    $attr_value = \App\Models\AttributeValue::with('attribute')->where('id', $attribute_value)->orderBy('display_order', 'ASC')->first();
                                    $attr_name = $attr_value->attribute->name;
                                    $attr_val= $attr_value->value;
                                }else{
                                    $attr_value = \App\Models\Attribute::with('attribute_values')->where('id', $attribute_id)->first();
                                    $attr_name = $attr_value->name;
                                    $attr_val= 'Unimportant';
                                }
                                $attributes[] = '<strong>'.$attr_name.'</strong>: '.$attr_val;
                            }
                        @endphp

                        @foreach($attributes as $attr)
                            <div>
                                {!! $attr !!}
                            </div>
                        @endforeach
                    </td>
                    <td style="border: 1px solid #000;text-align: center;">
                        @php
                        if(!empty($quantities[$product_type][$no])){
                            $quantity_total += (int)$quantities[$product_type][$no];
                        }
                        $i++;
                        @endphp
                        @if(!empty($quantities[$product_type][$no]))
                            {{ (int)$quantities[$product_type][$no] }}
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('Total')}} {{ ucfirst($product_type).'s'}}</th><td colspan="2" style="border: 1px solid #000;text-align: center;">{{ $quantity_total }}</td></tr>
            @endif
        @endforeach
    </tbody>
</table>
