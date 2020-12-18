@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="content-body">
                <!--Form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" style="height: 50px;">
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.add_standard')}}</h4>
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
                                        <form class="form" action="{{ route('standards.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __('site.name')}}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name">
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('standards.index')}}" method="post" class="btn btn-primary" type="submit">{{__('site.view_all') }}</a>    
                                                <button type="submit" class="btn btn-success">{{__('site.save')}}
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