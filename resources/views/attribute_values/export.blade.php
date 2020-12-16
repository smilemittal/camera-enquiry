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
                                    <h4 class="card-title" id="basic-layout-form">Add Attributes Values</h4>
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
                                                    <div class="card-body">
                                                        <form action="" method="POST" enctype="multipart/form-data">
                                                            {{ csrf_field() }}

                                                            <a class="btn btn-warning" href="{{ route('export') }}">Export Attribute Value</a>
                                                        </form>
                                                    </div> 
                                             </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
</div>
@endsection