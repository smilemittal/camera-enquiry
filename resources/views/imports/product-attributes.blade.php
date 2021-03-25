@extends('layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{ translate('Product Attribute') }}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ translate('Home') }}
                        </li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('products.index') }}">{{ translate('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('Import') }}
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
                            <h4 class="card-title" id="basic-layout-form"> {{ translate('Import') }}</h4>
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
                        <!-- Card content body start -->
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if (\Session::has('error'))
                                    <div class="alert alert-danger">
                                        @if (\Session::has('error'))
                                            <div>{{ \Session::get('error') }}</div>
                                        @endif
                                        {{-- @if ($errors->all())
                                            
                                                    @foreach ($errors->all() as $error)
                                                    <div>{{$error}}</div>
                                                    @endforeach

                                                @endif --}}
                                    </div>
                                @endif


                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('success') }}
                                    </div>
                                @endif
                                <form class="form" action="{{ route('product-attributes.post-import') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="values">{{ translate('File') }}</label>
                                            <input type="file" class="form-control" placeholder="Value"
                                                name="import-product-attributes">
                                            <label for="Example">{{ translate('Example') }}</label>
                                            <a href={{ asset('assets/frontend/example/product.xlsx') }}
                                                style="color:#464855;" download><i> </i>{{ translate('Download') }}</a>
                                        </div>
                                    </div>
                                    <div class="form-actions" style="text-align: center;">
                                        <button type="reset" class="btn btn-danger">
                                            <i class=""></i>{{ translate('Reset') }}
                                        </button>
                                        <button type="submit" class="btn btn-success">{{ translate('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="container">
                            <label for="values">{{ translate('Note*') }}</label>
                            <p>
                                Steps to import Product Attributes:<br>

                                Admin needs to download the Download CSV file example :<br>

                                When you are on the import page , you can see --> Download an example file.<br>
                                Download that sample file in your local system <br>
                                -> open that file in MS excel software - you can see all column headings - Now we have to
                                put all the values in below specific column.<br>
                                We can’t change any column heading (label name ), Don’t delete any column name.<br>

                                Open the downloaded file and fill the information of products like <br>
                                Product name:
                                <li> This field is required.</li>
                                <li>if product with same name already exist then it will not be added and if it doesn't
                                    then it will be added .</li><br>
                                Standard:
                                <li> This field is required.</li>
                                You can get existing standard values from here <a
                                    href="{{ route('standards.index') }}">{{ translate('Click Here ') }}</a>.</li><br>
                                System type:
                                <li> This field is required .
                                <li>You can get existing System type values from here <a
                                        href="{{ route('system-types.index') }}">{{ translate('Click Here ') }}</a>.
                                </li><br>
                                Type:
                                <li>This field is required .</li>
                                <li>You can get existing Type values from here <a
                                        href="{{ route('types.index') }}">{{ translate('Click Here ') }}</a>.</li><br>
                                Priority:
                                <li>This field is required .</li>
                                <li>and other Product attributes:</li>
                                <li>You can get existing Product attributes values from here <a
                                        href="{{ route('attribute-values.index') }}">{{ translate('Click Here ') }}</a>.
                                </li><br>

                                After putting the information of all products now you need to upload the file. <br>
                                choose the file and click on the Save button.<br>

                                You will see a message - file imported successfully and then<br>
                                Go to product -> list and you can see all imported data.<br>

                                If the file does not import successfully , you will see an error message that File is not
                                imported successfully.<br> It means there is some problem in your excel file and we have to
                                crosscheck , fix the problem and upload the excel file again.<br>

                            </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
