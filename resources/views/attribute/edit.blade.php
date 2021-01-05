@extends('layouts.app')

@section('content')

    <!-- BEGIN: Content-->
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <h4 class="content-header-title" id="basic-layout-form"> {{ __('site.Attributes')}}</h4>
                </div>
                <div class="content-header-right col-md-8 col-12">
                    <div class="breadcrumbs-top float-md-right">
                        <div class="breadcrumb-wrapper mr-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ __('site.Home')}}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('attribute.index') }}">{{ __('site.List')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('site.Edit')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">

                                    <h4>{{ __('site.Edit')}}</h4>

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
                                        <form method="post" action="{{ route('attribute.update', $attribute->id) }}" class="form" >
                                         @csrf
                                         @method('PATCH')
                                            <div class="form-body">
                                                        <div class="form-group">
                                                            <label for="type">{{ __('site.Type')}}</label>

                                                                <select id="type" name="type"  class="form-control">
                                                                        <option value="camera" @if($attribute->type == 'camera') selected  @endif>Camera</option>
                                                                        <option value="nvr" @if($attribute->type == 'nvr') selected  @endif>Nvr</option>
                                                                        <option value="recorder" @if($attribute->type == 'camera') selected  @endif>Recorder</option>
                                                                        <option value="switch" @if($attribute->type == 'switch') selected  @endif>Switch</option>
                                                                </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="system_type_id">{{ __('site.System Type')}}</label>
                                                           
                                                           <select name="system_type_id" id="system_type_id" class="form-control">
                                                            @foreach($system_types ?? '' as $system_type)
                                                                <option value="{{ $system_type->id }}" {{ $attribute->system_type_id == $system_type->id ? 'selected' : '' }}>{{ $system_type->name }}</option>
                                                            @endforeach 
                                                           </select>
                                                        </div>
                                                     <div class="form-group">
                                                            <label for="Name">{{ __('site.Attribute Name')}}</label>
                                                            <input type="text" id="name" class="form-control" value="{{$attribute->name}}" name="name">
                                                     </div> 
                                                     
                                                     <div class="form-group">
                                                            <label for="Name">{{ __('site.Display Order')}}</label>
                                                            <input type="text" id="display_order" class="form-control" value="{{$attribute->display_order}}" name="display_order">
                                                     </div> 
                                                     <div class="form-group">
                                                        <label for="Description">Description </label>
                                                        <textarea rows="5" class="form-control"  name="description"><?php echo htmlspecialchars($attribute->description);?></textarea>
                                                    </div>
                                                    <div class="form-actions" style="text-align:center">
                                                        <button type="reset"  class="btn btn-danger">
                                                            {{ __('site.Reset')}}
                                                        </button>           

                                                            <button type="submit" name="submit" class="btn btn-success">
                                                                {{ __('site.Save')}}
                                                            </button>
                                                     </div>
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

