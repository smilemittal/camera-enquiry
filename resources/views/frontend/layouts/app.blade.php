<!DOCTYPE html>
<html lang="en">
    <head>
        <title>home</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/frontend/fonts/stylesheet.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />

        @yield('styles')
    </head>

    <body>
        <!-- start-header -->
        <section class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="#"><img src="{{asset('assets/frontend/img/logo.png')}}" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav ml-auto">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Works</a></li>
                            <li><a href="#">Articles</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
        <!-- end-header -->

        
            @yield('content')


        <!-- ---------footer--------- -->
        <footer>
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <h4>BCS LINE</h4>
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Systemy IP</a></li>
                                        <li><a href="#">Rejestratory</a></li>
                                        <li><a href="#">Kamery</a></li>
                                        <li><a href="#">Akcesoria</a></li>
                                        <li><a href="#">Pulpity sterujące</a></li>
                                        <li><a href="#">Obiektywy MP</a></li>
                                        <li><a href="#">Urządzenia magazynujące</a></li>
                                        <li><a href="#">Dekodery/Serwery wideo</a></li>
                                        <li><a href="#">Monitory</a></li>
                                        <li><a href="#">Pliki</a></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Systemy HD ANALOG</a></li>
                                        <li><a href="#">HD-CVI (BCS-CVR)</a></li>
                                        <li><a href="#">Rejestratory</a></li>
                                        <li><a href="#">Kamery</a></li>
                                        <li><a href="#">5w1 (BCS-XVR)</a></li>
                                        <li><a href="#">Rejestratory</a></li>
                                        <li><a href="#">Kamery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <h4>BCS POINT</h4>
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Systemy IP</a></li>
                                        <li><a href="#">Rejestratory</a></li>
                                        <li><a href="#">Kamery</a></li>
                                        <li><a href="#">Akcesoria</a></li>
                                        <li><a href="#">Monitory</a></li>
                                        <li><a href="#">Pliki</a></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Systemy HD ANALOG</a></li>
                                        <li><a href="#">Rejestratory</a></li>
                                        <li><a href="#">Kamery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 pl-lg-0">
                            <h4>WIDEODOMOFONY</h4>
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Wideodomofony IP</a></li>
                                        <li><a href="#">Jednorodzinne</a></li>
                                        <li><a href="#">Modułowe</a></li>
                                        <li><a href="#">Wielorodzinne</a></li>
                                        <li><a href="#">Pliki</a></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul>
                                        <li><a href="#">Wideodomofony </a></li>
                                        <li><a href="#">2-przewodowe</a></li>
                                        <li><a href="#">Panele zewnętrzne</a></li>
                                        <li><a href="#">Monitory</a></li>
                                        <li><a href="#">Zestawy</a></li>
                                        <li><a href="#">Akcesoria</a></li>
                                        <li><a href="#">Pliki</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <h3>Firma</h3>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">O Nas</a></li>
                                    <li><a href="#">Szkolenia</a></li>
                                    <li><a href="#">Prasa</a></li>
                                </ul>
                            </div>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">Regulamin</a></li>
                                    <li><a href="#">Polityka prywatności</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <h3>Kontakt</h3>
                            <div class="footer-inner-text">
                                <ul>
                                    <li><a href="#">NSS Sp. z o.o.</a></li>
                                    <li><a href="#">ul. Modularna 11 (hala IV)</a></li>
                                    <li><a href="#">02-238 Warszawa</a></li>
                                    <li><a href="#">tel. +48 (22) 846 25 31</a></li>
                                    <li><a href="#">fax. +48 (22) 846 23 57</a></li>
                                    <li><a href="#">e-mail: info@nsssystem.pl</a></li>
                                </ul>
                            </div>
                            <div class="footer-inner-text">
                                <p class="pr-lg-5">Nasza firma jest do Państwa dyspozycji od poniedziałku do piątku w godzinach 9:00 - 17:00</p><br/>
                                <p>Mapa dojazdu</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 ml-auto pl-lg-0">
                            <h3>Newsletter</h3>
                            <div class="footer-inner-text">
                                <p>Jeżeli chcesz otrzymywać od nas informacje o fantastycznych wyprzedażach, nowościach w ofercie i nowych prezentach to koniecznie zapisz się na nasz Newsletter</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- ---------footer-close--------- -->

        <script src="{{asset('assets/frontend/js/jquery-3.2.1.slim.min.js')}}"></script>
        <script src="{{asset('assets/frontend/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/frontend/js/jquery.min.js')}}"></script>
        <script>
            $(".navbar-toggler").click(function () {
                $(this).find("i").toggleClass("fa-times");
            });
        </script>
        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
        </script>

        @yield('scripts')
    </body>
</html>