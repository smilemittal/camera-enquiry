<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="app-assets/images/backgrounds/02.jpg">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="#">
                         <img class="brand-logo" alt="camera admin logo" src="{{asset("assets/frontend/img/logo.png")}}" />
                        <!--h3 class="brand-text"> {{translate('Coming Soon')}}</h3-->
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
                    <a href="#"><i class="ft-edit"></i>
                        <span class="menu-title" data-i18n="">{{translate('System Types')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="@if(\Request::routeIs('system-types.create')) active @endif">
                            <a class="menu-item" href="{{ route('system-types.create') }}">{{translate('Add')}}</a>
                        </li>
                        <li class="@if(\Request::routeIs('system-types.index')) active @endif">
                            <a class="menu-item" href="{{ route('system-types.index') }}">{{translate('List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-edit"></i>
                        <span class="menu-title" data-i18n="">{{translate('Types')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="@if(\Request::routeIs('types.create')) active @endif">
                            <a class="menu-item" href="{{ route('types.create') }}">{{translate('Add')}}</a>
                        </li>
                        <li class="@if(\Request::routeIs('types.index')) active @endif">
                            <a class="menu-item" href="{{ route('types.index') }}">{{translate('List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-layers"></i>
                        <span class="menu-title" data-i18n="">{{translate('Standards')}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="@if(\Request::routeIs('standards.create')) active @endif">
                            <a class="menu-item" href="{{ route('standards.create') }}">{{translate('Add')}}</a>
                        </li>
                        <li class="@if(\Request::routeIs('standards.index')) active @endif">
                            <a class="menu-item" href="{{ route('standards.index') }}">{{translate('List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#"><i class="ft-package"></i>
                        <span class="menu-title" data-i18n="">{{translate('Products')}}</span></a>
                    <ul class="menu-content">
                        <li class="nav-item @if(\Request::routeIs('products.create')) active @endif">
                            <a class="menu-item" href="{{ route('products.create') }}">{{translate('Add')}} </a>
                        </li>
                        <li class="nav-item @if(\Request::routeIs('products.index')) active @endif">
                            <a class="menu-item" href="{{ route('products.index') }}"> {{translate('List')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="ft-check-circle"></i>
                        <span class="menu-title" data-i18n="">{{translate('Attributes')}}</span></a>
                    <ul class="menu-content">
                        <li class="nav-item @if(\Request::routeIs('attribute.create')) active @endif">
                            <a class="menu-item" href="{{ route('attribute.create') }}">{{translate('Add')}}</a>
                        </li>
                        <li class="nav-item @if(\Request::routeIs('attribute.index')) active @endif">
                            <a class="menu-item" href="{{ route('attribute.index') }}">{{translate('List')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#">{{translate('Attributes Values')}}</a>
                            <ul class="menu-content">
                                <li class="nav-item @if(\Request::routeIs('attribute-values.create')) active @endif">
                                    <a class="menu-item" href="{{ route('attribute-values.create') }}">{{translate('Add')}}</a>
                                </li>
                                <li class="nav-item @if(\Request::routeIs('attribute-values.index')) active @endif">
                                    <a class="menu-item" href="{{ route('attribute-values.index') }}">{{translate('List')}}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item @if(\Request::routeIs('enquiries.*')) active @endif">
                <a href="{{ route('enquiries.index') }}"><i class="ft-mail"></i>
                    <span class="menu-title" data-i18n="">{{ translate('Enquiries')}}</span></a>
                </li>
                <li class=" nav-item @if(\Request::routeIs('languages.*')) active @endif">
                <a href="{{ route('languages.index') }}"><i class="la la-language"></i>
                    <span class="menu-title" data-i18n="">{{translate('Languages')}}</span></a>
                </li>
            </ul>
        </div>
    </div>
<!-- END: Main Menu-->
