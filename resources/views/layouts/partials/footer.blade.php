<!-- BEGIN: Footer-->

    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">2021 &copy; Copyright <a class="text-bold-800 grey darken-2" href="#" target="_blank">BCS</a></span>
        </div>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <!-- END: Page JS-->

    <script>
        if ($('.dropdown-language').length > 0) {
                    $('.dropdown-language .dropdown-item').each(function() {
                        $(this).on('click', function(e){
                            e.preventDefault();
                            var $this = $(this);
                            var locale = $this.data('flag');
                            $.post('{{ route('language.change') }}',{_token:'{{ csrf_token() }}', locale:locale}, function(data){
                                location.reload();
                            });

                        });
                    });
                }
    </script>
