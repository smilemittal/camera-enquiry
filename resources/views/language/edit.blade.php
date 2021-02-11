@extends('layouts.app')  
@section('content')  
<!--BEGIN content--> 
<div class="row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{__('site.Language')}}</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                    </li>
                    {{-- <li class="breadcrumb-item"><a href="{{route('types.index')}}">{{__('site.List')}}</a>
                    </li> --}}
                    <li class="breadcrumb-item active">{{__('site.Edit')}}
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>            
<div class="content-body">
                <!-- Form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.Edit') }} </h4>
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
                                <!--Card Content-->
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @if($errors->all())
                                            <div class="alert alert-danger">
                                                @foreach($errors->all() as $error)
                                            
                                                    <p>{{$error}}</p> 
                                        
                                                @endforeach
                                            </div>
                                        @endif
                                       <form method="Post" action="{{route('languages.update',$languages->id)}}">  
                                        @method('PATCH')     
                                         @csrf
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __('site.Name') }}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="{{$languages->name}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">{{__('Code') }}</label>
                                                    <select class="select2-icons form-control" id="code" name="code">
                                                        @foreach(\File::files(base_path('public/app-assets/images/flags')) as $path)
                                                        <option value="{{ pathinfo($path)['filename'] }}" @if($languages->code == pathinfo($path)['filename']) selected @endif data-icon="<img src='{{ static_asset('app-assets/images/flags/'.pathinfo($path)['filename'].'.png') }}'"><span>{{ strtoupper(pathinfo($path)['filename']) }}</span></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label>{{ __('site.Rtl') }}</label>
                                                        <select class="form-control select-dropdown-1" name="rtl"
                                                            id="rtl">
                                                            <option value="1" @if ($languages->rtl == true) selected
                                                                @endif>{{ __('On') }}</option>
                                                            <option value="0" @if ($languages->rtl == false) selected
                                                                @endif>{{ __('Off') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <button type="reset" class="btn btn-danger">{{__('site.Reset')}}</button>
                                                <button type="submit" class="btn btn-success">{{ __('site.Save')}}
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
        </div>
    </div>  
  
@endsection