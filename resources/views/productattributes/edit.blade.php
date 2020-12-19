@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->

 <div class="content-body">
                <!--Form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.Edit Product Attributes')}}</h4>
                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="close">
                                                    <i class="ft-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @if($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                            
                                               <p>{{$error}}</p> 
                                        
                                            @endforeach
                                            </div>
                                        @endif
                                        <form class="form" action="{{ route('product-attributes.update',$id) }}" method="post">
                                            @method('PATCH')
                                            @csrf  
                                                <div class="form-group">
                                                    <label for="Product_id">{{__('site.Product')}}</label>
                                                    <select name="product_id" id="product_id" class="form-control">
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" {{ $product->id == $product_attributes->product_id ? 'selected' : '' }}>{{ $product->name }}</option>

                                                    @endforeach 
                                                    </select>                                                 
                                                </div>                                         
                                             <div class="form-group">
                                                    <label for="name">{{__('site.Attribute')}}</label>
                                               <select name="attribute_id" id="attribute_id" class="form-control">
                                                    @foreach($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}" {{ $attribute->id == $product_attributes->attribute_id ? 'selected' : '' }}>{{ $attribute->name }}</option>

                                                    
                                                    @endforeach 
                                               </select>
                                            </div>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{__('site.Attribute Value')}}</label>
                                                 <select name="attribute_value_id" id="attribute_value_id" class="form-control">
                                                    @foreach($attributevalues as $attributevalue)
                                                        
                                                        <option value="{{ $attributevalue->id }}" {{ $attributevalue->id == $product_attributes->attribute_value_id ? 'selected' : '' }}>{{ $attributevalue->value }}</option>

                                                    @endforeach 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('product-attributes.index')}}" method="post" class="btn btn-primary" type="submit">{{__('site.View all')}}</a>    
                                                <button type="submit" class="btn btn-success">{{__('site.Save')}}
                                                </button>
                                            </div>
                                          </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
</div>
@endsection