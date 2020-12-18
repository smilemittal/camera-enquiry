@extends('layouts.app')

@section('content')

    <!-- BEGIN: Content-->

            
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> {{ __('site.add_attribute')}}</h4>
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
                          
                                <div class="card-content collapse show">
                                    <div class="card-body " >
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
                                                <!--p>This is the most basic and default form having form section.</p-->
                                        </div>
                                        <form method="post" action="{{ route('attribute.store') }}" class="form" >
                                         @csrf
                                            <div class="form-body">
                                                     <div class="form-group">
                                                            <label for="Name">{{ __('site.attribute_name')}}</label>
                                                            <input type="text" id="name" class="form-control" placeholder="Name" name="name">
                                                     </div> 
                                                     <div class="form-group">
                                                            <label for="Name">{{ __('site.display_order')}}</label>
                                                            <input type="text" id="display_order" class="form-control" placeholder="display_order" name="display_order">
                                                     </div> 
                                                       <div class="form-group">
                                                            <label for="system_type_id">{{ __('site.system_type')}}</label>
                                                           
                                                           <select name="system_type_id" id="system_type_id" class="form-control">
                                                            @foreach($system_types as $system_type)
                                                                <option value="{{ $system_type->id }}">{{ $system_type->name }}</option>
                                                            @endforeach
                                                           </select>
                                                     </div> 
                                                     <div class="form-group">
                                                            <label for="type">{{ __('site.type')}}</label>
                                                                <select id="type" name="type" class="form-control">
                                                                        <option value="camera">Camera</option>
                                                                        <option value="nvr">Nvr</option>
                                                                        <option value="recorder">Recorder</option>
                                                                        <option value="switch">Switch</option>
                                                                </select>
                                                     </div>

                                                    <div class="form-actions" style="text-align:center">
                                                            <a  class=" btn btn-primary" href="{{ route('attribute.index') }}"> {{__('site.view_all')}}</a>           
                                                            <button type="submit" name="submit" class="btn btn-success">
                                                                {{__('site.save')}}
                                                            </button>   
                                                   </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
       
    <!-- END: Content-->

@endsection

