<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
{{-- <table class="table table-responsive table-bordered table-striped" style="display:table; width: 80%; margin-left: auto; margin-right: auto">
    <thead>
        <tr>
            
            <th>Type</th>
           
            <th>Product Details</th>
            <th>Quantity</th>
        </tr>
        
    </thead>
    <tbody>
      
        @php
            $product_name = '';
            $quantity_total = 0;
            // $products = json_decode($enquiry->products, true);
            // $quantities  = json_decode($enquiry->quantity, true);
        @endphp
        <tr>
                                        
            @foreach($products as $product_type => $product)
            <td>     {{ ucfirst($product_type) }}</td>
               
               
                

            <td>
                    @php
                    $i= 1;
                    $quantity_total = 0;
                    @endphp
                    @foreach($product as $no => $attribute_values)
                        @php    
                            $attributes = $attribute_values_arr = [];

                            foreach($attribute_values as $attribute_value){
                        
                                $attr_value = \App\Models\AttributeValue::with('attribute')->where('id', $attribute_value)->orderBy('display_order', 'ASC')->first();
                                
                                $attr_name = $attr_value->attribute->name;
                                $attr_val= $attr_value->value;

                                $attributes[] = '<strong>'.$attr_name.'</strong>: '.$attr_val; 
                            }
                     
                        

                        @endphp
                            <strong>Product No: -</strong> {{ $i }}  
                                @foreach($attributes as $attr)
                                <div>
                                {!! $attr !!}
                                </div>
                                    
                                
                                @endforeach
                 
                            @if(!empty($quantities[$product_type][$no]))
                            @php
                                 $quantity_total += (int)$quantities[$product_type][$no];
                            @endphp
                           
                            @endif
                            @php
                                $i++;
                            @endphp
                        
                    @endforeach
                </td>
            <td>{{ $quantity_total }}</td>

            </tr> 

            @endforeach


      

    </tbody>
</table> --}}

<table class="table table-bordered table-striped">


    <tbody>
      
        @php
            $product_name = '';
            $quantity_total = 0;
          
        @endphp
       
                                        
            @foreach($products as $product_type => $product)
            <tr><th>Product Type</th><td>     {{ ucfirst($product_type) }}</td><tr>
            <tr><th colspan="2" style="text-align: center">Product Details</th></tr>
            <tr><th>S. No.</th><th>Attributes</th></tr>

            @php
            $i= 1;
            $quantity_total = 0;
            @endphp
                @foreach($product as $no => $attribute_values)
                <tr>
                <td>{{  $i }}</td>
                <td>
                    @php    
                        $attributes = $attribute_values_arr = [];

                        foreach($attribute_values as $attribute_value){
                    
                            $attr_value = \App\Models\AttributeValue::with('attribute')->where('id', $attribute_value)->orderBy('display_order', 'ASC')->first();
                            
                            $attr_name = $attr_value->attribute->name;
                            $attr_val= $attr_value->value;

                            $attributes[] = '<strong>'.$attr_name.'</strong>: '.$attr_val; 
                        }
                    @endphp
                        
                    @foreach($attributes as $attr)
                        <div>
                            {!! $attr !!}
                        </div>
                        
                    
                    @endforeach
                    @php
                        if(!empty($quantities[$product_type][$no])){
                            $quantity_total += (int)$quantities[$product_type][$no];
                        }
                        $i++;
                    @endphp
                    <div>
                       <strong>Quantity: </strong> {{ (int)$quantities[$product_type][$no] }}
                    </div>
                    </td>   
                </tr>
               
                @endforeach
                
 
                <tr><th>Total {{ ucfirst($product_type).'s'}}<td>{{ $quantity_total }}</td>
                <tr rowspan="2"><td colspan="2"></td></tr>
            @endforeach
           

      

    </tbody>
</table>