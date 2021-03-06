<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ translate('Home') }}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/fonts/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />

    @yield('styles')
</head>

<body>
    <!-- start-header -->
    <section class="header">
        <div class="container">
            <div class="col-lg-7 col">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    {{-- @if (get_setting('show_language_switcher') == 'on') --}}
                    <li class="list-inline-item dropdown mr-3" id="lang-change">
                        @php
                            if (Session::has('locale')) {
                                $locale = Session::get('locale');
                            } else {
                                $locale = default_language();
                            }
                        
                            $current_lang = \App\Models\Language::where('code', $locale)->first();
                          
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown"
                            data-display="static">
                            <img src="{{ asset('app-assets/images/flags/' . $locale . '.png') }}"
                                alt="{{ $current_lang->name }}">
                            <span class="opacity-60">{{ $current_lang->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Models\Language::all() as $key => $language)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                        class="dropdown-item @if ($locale==$language) active @endif">
                                        <img src="{{ asset('app-assets/images/flags/' . $language->code . '.png') }}"
                                            alt="{{ $language->name }}">
                                        <span class="language">{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="list-inline-item dropdown mr-3" id="currency-change">
                        @php
                            if (Session::has('default_currency')) {
                                $default_currency = Session::get('default_currency');
                            } else {
                                $default_currency = default_currency();
                            }
                        
                            $current_currency = \App\Models\Currency::where('code', $default_currency)->first();
                          
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown"
                            data-display="static">
                            {{-- <img src="{{ asset('app-assets/images/flags/' . $locale . '.png') }}"
                                alt="{{ $current_lang->name }}"> --}}
                            <span class="opacity-60">{{ $current_currency->symbol." ".$current_currency->code }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Models\Currency::all() as $key => $currency)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $currency->code }}"
                                        class="dropdown-item @if ($current_currency==$currency) active @endif">
                                        {{-- <img src="{{ asset('app-assets/images/flags/' . $currency->code . '.png') }}"
                                            alt="{{ $currency->name }}"> --}}
                                        <span class="language">{{ $currency->symbol." ".$currency->code }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                {{-- @endif --}}
            </div>
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#"><img src="{{ asset('assets/frontend/img/logo.png') }}" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    {{-- <ul class="navbar-nav ml-auto">
                            <li><a href="#">{{translate('Home')}}</a></li>
                            <li><a href="#">{{translate('Works')}}</a></li>
                            <li><a href="#">{{translate('Articles')}}</a></li>
                            <li><a href="#">{{translate('Contact Us')}}</a></li>
                        </ul> --}}
                </div>
            </nav>
        </div>
    </section>
    <!-- end-header -->


    @yield('content')


    <!-- ---------footer--------- -->
    {{-- <footer>
            <div class="footer-middle">
                <div class="container">
                    <div class="footer-map">
                        <img src="{{asset("assets/frontend/img/footer-map.png")}}" />
                    </div>
                </div>
            </div>

            <div class="footer-botom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-12">
                            <h3>{{translate('Firma')}}</h3>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">{{translate('O Nas')}}</a></li>
                                    <li><a href="#">{{translate('Szkolenia')}}</a></li>
                                    <li><a href="#">{{translate('Prasa')}}</a></li>
                                </ul>
                            </div>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">{{translate('Regulamin')}}</a></li>
                                    <li><a href="#">{{translate('Polityka prywatno??ci')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <h3>{{translate('Kontakt')}}</h3>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">{{translate('NSS Sp. z o.o.')}}</a></li>
                                    <li><a href="#">{{translate('ul. Modularna 11 (hala IV)')}}</a></li>
                                    <li><a href="#">{{translate('02-238 Warszawa')}}</a></li>
                                    <li><a href="#">{{translate('tel. +48 (22) 846 25 31')}}</a></li>
                                    <li><a href="#">{{translate('fax. +48 (22) 846 23 57')}}</a></li>
                                    <li><a href="#">{{translate('e-mail: info@nsssystem.pl')}}</a></li>
                                </ul>
                            </div>
                            <div class="footer-inner-text">
                                <p class="pr-lg-5">{{translate('Nasza firma jest do Pa??stwa dyspozycji od poniedzia??ku do pi??tku w godzinach 9:00 - 17:00')}}</p><br/>
                                <p>{{translate('Mapa dojazdu')}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 ml-auto pl-lg-0">
                            <h3>{{translate('Newsletter')}}</h3>
                            <div class="footer-inner-text">
                                <p>{{translate('Je??eli chcesz otrzymywa?? od nas informacje o fantastycznych wyprzeda??ach, nowo??ciach w ofercie i nowych prezentach to koniecznie zapisz si?? na nasz Newsletter')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}
    <!-- ---------footer-close--------- -->

    <script src="{{ asset('assets/frontend/js/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script>
        $(".navbar-toggler").click(function() {
            $(this).find("i").toggleClass("fa-times");
        });

    </script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }

        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-item').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change') }}', {
                        _token: '{{ csrf_token() }}',
                        locale: locale
                    }, function(data) {
                        location.reload();
                    });

                });
            });
        }

        if ($('#currency-change').length > 0) {
            $('#currency-change .dropdown-item').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var default_currency = $this.data('flag');
                    $.post('{{ route('currency.change') }}', {
                        _token: '{{ csrf_token() }}',
                        default_currency: default_currency
                    }, function(data) {
                        location.reload();
                    });

                });
            });
        }

    </script>

    @yield('scripts')
</body>

</html>
