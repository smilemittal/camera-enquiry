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
                                    <h4 class="card-title" id="basic-layout-form">Import System Types</h4>
                                        <a class="heading-elements-toggle">
                                            <i class="la la-ellipsis-v font-medium-3"></i>
                                        </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="close">
                                                    <i class="ft-x"></i>
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
                                                    <label for="values">Value</label>
                                                    <input type="file" class="form-control" placeholder="Value" name="import-system-types">
                                                </div>
                                               
                                            </div>
                                            <div class="form-actions" style="text-align: center;">
                                                <a href="{{ route('system_types.index')}}" method="post" class="btn btn-primary" type="submit"> View all</a>    
                                                <button type="submit" class="btn btn-success">Save</button>
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