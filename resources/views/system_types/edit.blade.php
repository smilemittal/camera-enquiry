 @extends('layouts.app')  
@section('content')  
<!--BEGIN content--> 
<div class="row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{__('site.system_types')}}</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{__('site.home')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">{{__('site.edit')}}</a>
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
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.edit_system_type') }} </h4>
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
                                       <form method="Post" action="{{route('system-types.update',$system_types->id)}}">  
                                        @method('PATCH')     
                                         @csrf
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __('site.name') }}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="{{$system_types->name}}">
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <button type="reset" class="btn btn-primary">{{__('site.reset')}}</button>
                                                {{-- <a href="{{ route('system-types.index')}}" method="post" class="btn btn-primary" type="submit">{{ __('site.cancel') }}</a> --}}
                                                <button type="submit" class="btn btn-success">{{ __('site.save')}}
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