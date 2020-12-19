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
                                <h4 class="card-title" id="basic-layout-form">{{ __('site.Add System Types') }}</a></h4>
                                    
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
                                                <div class="form-group">
                                                    <label for="name">{{ __('site.Name') }}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name">
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('system-types.index')}}" method="post" class="btn btn-primary"> {{ __('site.View all')}}</a>    
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