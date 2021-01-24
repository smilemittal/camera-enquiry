<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="app-assets/images/backgrounds/02.jpg">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="#">
                         <img class="brand-logo" alt="camera admin logo" src="{{asset("assets/frontend/img/logo.png")}}" />
                        <!--h3 class="brand-text"> {{__('site.Coming Soon')}}</h3-->
                    </a>
                </li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar">
                    <i class="ft-x"></i></a>
                </li>
            </ul>
        </div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item">
                    <a href="#"><i class="ft-home"></i>
                    <span class="menu-title" data-i18n="">{{__('site.DashBoard')}}</span></a>
                </li>   
                <li class=" nav-item">
                    <a href="#"><i class="ft-edit"></i>
                        <span class="menu-title" data-i18n="">{{__('site.System Types')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="">
                            <a class="menu-item" href="{{ route('system-types.create') }}">{{__('site.Add')}}</a>
                        </li>
                        <li>
                            <a class="menu-item" href="{{ route('system-types.index') }}">{{__('site.List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-edit"></i>
                        <span class="menu-title" data-i18n="">{{__('site.Types')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="">
                            <a class="menu-item" href="{{ route('types.create') }}">{{__('site.Add')}}</a>
                        </li>
                        <li>
                            <a class="menu-item" href="{{ route('types.index') }}">{{__('site.List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-layers"></i>
                        <span class="menu-title" data-i18n="">{{__('site.Standards')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="">
                            <a class="menu-item" href="{{ route('standards.create') }}">{{__('site.Add')}}</a>
                        </li>
                        <li>
                            <a class="menu-item" href="{{ route('standards.index') }}">{{__('site.List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-package"></i>
                        <span class="menu-title" data-i18n="">{{__('site.Products')}}</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('products.create') }}">{{__('site.Add')}} </a>
                        </li>
                        <li>
                            <a class="menu-item" href="{{ route('products.index') }}"> {{__('site.List')}}</a>
                        </li>   
                    </ul>
                </li>
                <li class="nav-item @if(\Route::currentRouteName() == 'attribute.create' || \Route::currentRouteName() == 'attribute.index' || \Route::currentRouteName() == 'attribute-values.create' || \Route::currentRouteName() == 'attribute-values.index') open @endif">
                    <a href="#"><i class="ft-check-circle"></i>
                        <span class="menu-title" data-i18n="">{{__('site.Attributes')}}</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a class="menu-item" href="{{ route('attribute.create') }}">{{__('site.Add')}}</a>
                        </li>
                        <li>
                            <a class="menu-item" href="{{ route('attribute.index') }}">{{__('site.List')}}</a>
                        </li>
                        <li class=" @if(\Route::currentRouteName() == 'attribute-values.create' || \Route::currentRouteName() == 'attribute-values.index') open @endif"><a class="menu-item " href="#">{{__('site.Attributes Values')}}</a>
                            <ul class="menu-content">
                                <li class="">
                                    <a class="menu-item" href="{{ route('attribute-values.create') }}">{{__('site.Add')}}</a>
                                </li>
                                <li>
                                    <a class="menu-item" href="{{ route('attribute-values.index') }}">{{__('site.List')}}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                <a href="{{ route('enquiries.index') }}"><i class="ft-mail"></i>
                    <span class="menu-title" data-i18n="">{{ __('site.Enquiries')}}</span></a>
                </li>   
            </ul>
        </div>
    </div>
<!-- END: Main Menu-->
