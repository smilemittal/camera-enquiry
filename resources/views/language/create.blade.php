@extends('layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{translate('Language') }}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{translate('Home') }}</a>
                        </li>
                        {{-- <li class="breadcrumb-item"><a href="{{ route('system-types.index') }}">{{translate('site.List')}}</a> --}}
                        </li>
                        <li class="breadcrumb-item active">{{translate('Add') }}
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

                            <h3 class="card-title" id="basic-layout-form">{{translate('Add') }} </h3>
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
                                @if ($errors->all())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <form class="form" action="{{ route('languages.store') }}" method="post">
                                    @csrf
                                    <div class="form-body">
                                        <div class="form-group {{ $errors->get('name') ? 'has-error' : '' }}">
                                            <label for="name">{{translate('Name') }}</label>
                                            <input type="text" name="name" placeholder="Name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">{{translate('Code') }}</label>
                                            <select class="country-flag-select form-control" id="code" name="code">
                                                @foreach(\File::files(base_path('public/app-assets/images/flags')) as $path)
                                                <option value="{{ pathinfo($path)['filename'] }}" data-icon="<img src='{{ static_asset('app-assets/images/flags/'.pathinfo($path)['filename'].'.png') }}'"><span>{{ strtoupper(pathinfo($path)['filename']) }}</span></option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-actions" style="text-align: center;">
                                            <button type="reset" name="submit" class="btn btn-danger">{{translate('Reset') }}
                                            </button>

                                            <button type="submit" name="submit"
                                                class="btn btn-success">{{translate('Save') }}
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
    </div>
@endsection
@section('scripts')
<script>
     $(".country-flag-select").select2({
        templateResult: countryCodeFlag,
        templateSelection: countryCodeFlag,
        escapeMarkup: function (m) {
            return m;
        },
    });
    function countryCodeFlag(state) {
        var flagName = $(state.element).data("flag");
        if (!flagName) return state.text;
        return (
            "<img  class='flag' src='" +
            flagName +
            "' height='14' />" +
            state.text
        );
    }
</script>

@endsection
