<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-textdirection="rtl">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
{{-- <html class="loading" lang="en" data-textdirection="ltr"> --}}
<!-- BEGIN: Head-->

@include('layouts.partials.head')
<!-- Page Css -->

<!-- Page Css End -->
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">

<!-- BEGIN: Header-->
@include('layouts.partials.header')
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
@include('layouts.partials.sidebar')
<!-- END: Main Menu-->
<!-- BEGIN: Content-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        @yield('content')
    </div>
</div>

<!-- END: Content-->

@include('layouts.partials.footer')
<!-- Page Scripts -->
@yield('scripts')
<!-- Page scripts end -->
</body>
<!-- END: Body-->

</html>
