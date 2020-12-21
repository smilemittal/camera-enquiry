@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
                    <div class="content-header row">
                        <div class="content-header-left col-md-4 col-12 mb-2">
                            <h3 class="content-header-title">Standard</h3>
                        </div>
                        <div class="content-header-right col-md-8 col-12">
                            <div class="breadcrumbs-top float-md-right">
                                <div class="breadcrumb-wrapper mr-1">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('standards.index') }}">{{__('site.List')}}</a>
                                        </li>
                                        <li class="breadcrumb-item active"><a href="">{{__('site.Add')}}</a>
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
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.Add')}}</h4>

                                    <div class="card-content collapse show">
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
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                         <div class="card-text">
                                            @if(\Session::has('success'))
                                                <div class="alert alert-success">
                                                        {{\Session::get('success')}}
                                                </div>
                                            @endif

                                        @if($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <p>{{$error}}</p> 
                                        
                                            @endforeach
                                            </div>
                                        @endif 
                                    </div>
                                        <form class="form" action="{{ route('standards.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __('site.Name')}}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name">
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <button type="Reset" class="btn btn-danger">{{ __('site.Reset')}}
                                                </button>
                                               
                                                <button type="submit" class="btn btn-success">{{ __('site.Save')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
</div>
@endsection