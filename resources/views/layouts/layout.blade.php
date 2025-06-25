<!doctype html>

<html lang="pt" class=" layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-skin="default"
    data-assets-path={{ asset('/') }} data-template="vertical-menu-template" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{config("app.name")}}</title>

    <!-- Canonical SEO -->
    <meta name="description"
        content="Sneat is the best bootstrap 5 dashboard for responsive web apps. Streamline your app development process with ease." />
    <meta name="keywords"
        content="Sneat bootstrap dashboard, sneat bootstrap 5 dashboard, themeselection, html dashboard, web dashboard, frontend dashboard, responsive bootstrap theme" />
    <meta property="og:title" content="Sneat Bootstrap 5 Dashboard PRO by ThemeSelection" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/" />
    <meta property="og:image"
        content="https://themeselection.com/wp-content/uploads/edd/2024/08/sneat-dashboard-pro-bootstrap-smm-image.png" />
    <meta property="og:description"
        content="Sneat is the best bootstrap 5 dashboard for responsive web apps. Streamline your app development process with ease." />
    <meta property="og:site_name" content="ThemeSelection" />
    <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href={{ asset('/img/logo7rm.png') }} />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href={{ asset('/vendor/fonts/iconify-icons.css') }} />
    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->
    <link rel="stylesheet" href={{ asset('/vendor/libs/pickr/pickr-themes.css') }} />
    <link rel="stylesheet" href={{ asset('/vendor/css/core.css') }} />
    <link rel="stylesheet" href={{ asset('/css/demo.css') }} />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href={{ asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} />
    <!-- endbuild -->
    <link rel="stylesheet" href={{ asset('/vendor/fonts/flag-icons.css') }} />
    <link rel="stylesheet" href={{ asset('/vendor/libs/apex-charts/apex-charts.css') }} />
    @stack('styles')
    <!-- Page CSS -->
    <!-- Helpers -->
    <script src={{ asset('/vendor/js/helpers.js') }}></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src={{ asset('/vendor/js/template-customizer.js') }}></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src={{ asset('/js/config.js') }}></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.menulateral');
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.navbar')
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <input type="hidden" id='_token' name="_token" value="{{csrf_token()}}" />
                    <div class="container-xxl flex-grow-1 container-p-y">
                      @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>, made by <a href="#"
                                        target="" class="footer-link">3° SGT Lins</a>
                                </div>
                                {{-- <div class="d-none d-lg-inline-block">

                                    <a href="https://themeselection.com/license/" class="footer-link me-4"
                                        target="_blank">License</a>
                                    <a href="https://themeselection.com/" target="_blank"
                                        class="footer-link me-4">More Themes</a>

                                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>


                                    <a href="https://themeselection.com/support/" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Support</a>

                                </div> --}}
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>

    </div>
    <!-- / Layout wrapper -->

    <script src={{ asset('/vendor/libs/jquery/jquery.js') }}></script>
    <script src={{ asset('/vendor/libs/popper/popper.js') }}></script>
    <script src={{ asset('/vendor/js/bootstrap.js') }}></script>
    <script src={{ asset('/vendor/libs/@algolia/autocomplete-js.js') }}></script>
    <script src={{ asset('/vendor/libs/pickr/pickr.js') }}></script>
    <script src={{ asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}></script>
    <script src={{ asset('/vendor/libs/hammer/hammer.js') }}></script>
    <script src={{ asset('/vendor/libs/i18n/i18n.js') }}></script>
    <script src={{ asset('/vendor/js/menu.js') }}></script>

    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src={{ asset('/vendor/libs/apex-charts/apexcharts.js') }}></script>
    <!-- Main JS -->
    <script src={{ asset('/js/main.js') }}></script>
    <!-- Page JS -->
    @stack('scripts')
</body>

</html>

<!-- beautify ignore:end -->
