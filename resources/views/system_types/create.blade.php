@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="content-header row">
<div class="content-header-left col-md-4 col-12 mb-2">
    <h3 class="content-header-title">{{__('site.System Types')}}</h3>
</div>
<div class="content-header-right col-md-8 col-12">
    <div class="breadcrumbs-top float-md-right">
        <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                </li>
                <li class="breadcrumb-item"><a href="#">{{__('site.Add')}}</a>
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
                                 <h3>{{__('site.Add')}} </h3>
                                {{-- <h4 class="card-title" id="basic-layout-form">{{ __('site.add_system_types') }}</a></h4> --}}
                                    
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
                                        <form class="form" action="{{ route('system-types.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                <div class="form-group {{ $errors->get('name') ? 'has-error' : '' }}">
                                                    <label for="name">{{ __('site.Name') }}</label>
                                                    <input type="text" name="name" placeholder="Name" class="form-control" required>
                                                  </div> 
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <button type="reset" name="submit" class="btn btn-danger">{{__('site.Reset')}}
                                                </button>
                                                <button type="submit" name="submit" class="btn btn-success">{{__('site.Save')}}
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