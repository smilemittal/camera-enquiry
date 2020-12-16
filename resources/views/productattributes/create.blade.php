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
                                    <h4 class="card-title" id="basic-layout-form">Add Product Attributes</h4>
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
                                        <form class="form" action="{{ route('product-attributes.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="product_id">Product </label>
                                                    <select name="product_id" id="product_id" class="form-control">
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach 
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="attribute_id">Attribute </label>
                                                 <select name="attribute_id" id="attribute_id" class="form-control">
                                                    @foreach($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                    @endforeach 
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="attributes_value_id">Attribute Value </label>
                                                   <select name="attribute_value_id" id="attribute_value_id" class="form-control">
                                                    @foreach($attributevalues as $attributevalue)
                                                        <option value="{{ $attributevalue->id }}">{{ $attributevalue->value }}</option>
                                                    @endforeach 
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('product-attributes.index')}}" method="post" class="btn btn-primary" type="submit">View all</a>    
                                                <button type="submit" class="btn btn-success">Save
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