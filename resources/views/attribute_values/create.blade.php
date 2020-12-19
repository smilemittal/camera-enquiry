@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="row">
<div class="content-header-left col-md-4 col-12 mb-2">
    <h3 class="content-header-title">{{__('site.attributes_values')}}</h3>
</div>
<div class="content-header-right col-md-8 col-12">
    <div class="breadcrumbs-top float-md-right">
        <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{__('site.home')}}</a>
                </li>
                <li class="breadcrumb-item"><a href="#">{{__('site.add')}}</a>
                </li>
            </ol>
        </div>
    </div>
</div>
</div>
<div class="content-body">
                  <!--Form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" style="height: 50px;">
                                    <h4 class="card-title" id="basic-layout-form">Add Attributes Values</h4>
                                </div>
                            <!-- Card content body start -->
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @if($errors->all())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                           <p>{{$error}}</p> 
                                        @endforeach
                                    </div>
                                        @endif
                                        <form class="form" action="{{ route('attribute-values.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                
                                                    <div class="form-group">
                                                    <label for="system_type_id">{{ __('site.system_type')}}</label>
                                                    <select name="system_type_id" id="system_type_id" class="form-control">

                                                        @foreach($system_types as $system_type)

                                                           <option value="{{ $system_type->id }}">{{ $system_type->name }}</option>

                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="attribute_id">{{__('site.attribute')}} </label>
                                                    <select name="attribute_id" id="attribute_id" class="form-control">
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}
                                                                </option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                                <div  class="form-group">
                                                    <label for="values">{{ __('site.value')}}</label>
                                                    <input type="text" class="form-control" placeholder="Value" name="value">
                                                </div>
                                                <div class="form-group">
                                                    <label for="displayorder">{{ __('site.display_order')}}</label>
                                                    <input type="text" class="form-control" placeholder="Display Order" name="display_order">
                                                </div>
                                                
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('attribute-values.index')}}" method="post" class="btn btn-primary" type="submit">{{ __('site.view_all')}}</a>    
                                                <button type="submit" class="btn btn-success">{{ __('site.save')}}</button>
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