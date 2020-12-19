@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{__('site.Attribute Value')}}</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('site.List')}}
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
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.Edit')}}</h4>
                                        <a class="heading-elements-toggle">
                                            <i class="la la-ellipsis-v font-medium-3"></i>
                                        </a>
                                        <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="expand">
                                                            <i class="ft-maximize"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                        </div>
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
                                    <form method="Post" action="{{ route('attribute-values.update',$attribute_value->id)}}">
                                        @method('PATCH') 
                                        @csrf  
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="attribute_id">{{__('site.Attribute')}} </label>
                                                    <select name="attribute_id" id="attribute_id" class="form-control">
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}" {{ $attribute->id == $attribute_value->attribute_id ? 'selected' : '' }}>{{ $attribute->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="values">{{__('site.Value')}}</label>
                                                    <input type="text" class="form-control" placeholder="Value" name="value" value="{{$attribute_value->value}}">
                                                </div>
                                                <div class="form-group">         
                                                    <label for="displayorder">{{__('site.Display Order')}}</label>
                                                    <input type="text" class="form-control" placeholder="Display Order" name="display_order" value="{{$attribute_value->display_order}}">
                                                </div>                
                                                <div class="form-group">
                                                    <label for="system_type_id">{{__('site.System Type')}}</label>
                                                    <select name="system_type_id" id="system_type_id" class="form-control">

                                                        @foreach($system_types as $system_type)
                                                            
                                                            <option value="{{ $system_type->id }}" {{ $system_type->id == $attribute_value->system_type_id ? 'selected' : '' }}>{{ $system_type->name }}</option>
                                                        
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <button type="reset" class="btn btn-danger">{{__('site.Reset')}}</button>
                                                {{-- <a href="{{ route('attribute-values.index')}}" method="post" class="btn btn-primary" type="submit">{{__('site.view_all')}}</a>     --}}
                                                <button type="submit" class="btn btn-success">{{__('site.Save')}}</button>
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