@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="content-header row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{__('site.System Type')}}</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('attribute-values.index') }}">{{__('site.List')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('site.Import')}}</a>
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
                                    <h4 class="card-title" id="basic-layout-form"> {{ __('site.Import')}}</h4>
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
                                        @if(\Session::has('success'))
                                            <div class="alert alert-success">
                                        {{\Session::get('success')}}
                                            </div>
                                        @endif
                                        <form class="form" action="{{ route('system-types.post-import') }}" method="post" enctype="multipart/form-data">
                                            @csrf  
                                            <div class="form-body">
                                                <div  class="form-group">
                                                    <label for="values">{{__('site.Value')}}</label>
                                                    <input type="file" class="form-control" placeholder="Value" name="import-system-types">
                                                </div>
                                               
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('system-types.index')}}" method="post" class="btn btn-primary" type="submit">{{__('site.View all')}}</a>    
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