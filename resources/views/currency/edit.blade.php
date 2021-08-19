@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            {{-- <h4 class="content-header-title" id="basic-layout-form">{{ translate('Products') }}</h4> --}}
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('currency.index') }}">{{ translate('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('Add') }}
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
                            <h4 class="card-title" id="basic-layout-form">{{ translate('Edit') }}</h4>
                            <a class="heading-elements-toggle">
                                <i class="la la-ellipsis-v font-medium-3"></i>
                            </a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <a data-action="expand">
                                        <i class="ft-maximize"></i>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body ">
                                <div class="card-text">
                                    @if (\Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ \Session::get('success') }}
                                        </div>
                                    @endif
                                    @if ($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)

                                                <p>{{ $error }}</p>

                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('currency.update', $currency->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                 
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="name">{{translate('Name')}}</label>
                                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required value="{{ $currency->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="symbol">{{translate('Symbol')}}</label>
                                            <input type="text" placeholder="{{translate('Symbol')}}" id="symbol" name="symbol" class="form-control" required value="{{ $currency->symbol }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="code">{{translate('Code')}}</label> 
                                            <input type="text" placeholder="{{translate('Code')}}" id="code" name="code" class="form-control" required value="{{ $currency->code }}"> 
                                        </div>
                                        <div class="form-group">
                                            <label for="exchange_rate">{{translate('Exchange Rate')}}</label>
                                            <input type="number" step="0.01" min="0" placeholder="{{translate('Exchange Rate')}}" id="exchange_rate" name="exchange_rate" class="form-control" required value="{{ $currency->exchange_rate }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{translate('Status')}}</label>
                                            <select id="status" name="status" class="form-control">
                                                @foreach(\App\Models\Currency::STATUS as $status_id => $value)
                                                    <option value="{{ $status_id }}" @if($currency->status == $status_id) selected @endif>{{ translate($value) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-actions" style="text-align: center;">
                                        <button type="reset" class="btn btn-danger">{{ translate('Reset') }}</button>
                                        <button type="submit"
                                            class="btn btn-success">{{ translate('Save') }}</button>
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
