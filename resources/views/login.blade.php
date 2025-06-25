<!doctype html>
<html lang="pt_BR" class=" layout-wide  customizer-hide" dir="ltr" data-skin="default"
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

    <!-- Vendor -->
    <link rel="stylesheet" href={{ asset('/vendor/libs/@form-validation/form-validation.css') }} />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href={{ asset('/vendor/css/pages/page-auth.css') }} />

    <!-- Helpers -->
    <script src={{ asset('/vendor/js/helpers.js') }}></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src={{ asset('/vendor/js/template-customizer.js') }}></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src={{ asset('/js/config.js') }}></script>

</head>

<body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="index.html" class="app-brand auth-cover-brand gap-2">
            <span class="app-brand-logo demo">
                <span class="text-primary">

                </span>
            </span>
            <span class="app-brand-text demo text-heading fw-bold">{{config("app.name")}}</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                <div class="w-100 d-flex justify-content-center">
                    <img src={{ asset('/img/logo7rm.png') }} class="img-fluid" alt="Login image" width="380"
                        data-app-dark-img={{ asset('/img/logo7rm.png') }}
                        data-app-light-img={{ asset('/img/logo7rm.png') }} />
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
                <div class="w-px-400 mx-auto mt-sm-12 mt-8">
                    <h4 class="mb-1">Bem vindo ao {{config("app.name")}} 👋</h4>

                    <form id="formAuthentication" class="mb-6" action={{ route('logar') }} method="post">
                        @csrf
                        <div class="mb-6 form-control-validation">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf @error('cpf') is-invalid @enderror" id="cpf" name="cpf"
                                placeholder="Entre com seu CPF" autofocus value="{{ old('cpf') }}" />
                            @error('cpf')
                                <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-password-toggle form-control-validation">
                            <label class="form-label" for="password">Senha</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
                            @error('password')
                                <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-7">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                    <label class="form-check-label" for="remember">Lembre me</label>
                                </div>
                                <a href="auth-forgot-password-cover.html">
                                    <p class="mb-0">Esqueci a senha?</p>
                                </a>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Entrar</button>
                    </form>

                    <p class="text-center">
                        <span>Novo aqui?</span>
                        <a href="auth-register-cover.html">
                            <span>Crie uma conta</span>
                        </a>
                    </p>


                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

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
    <script src={{ asset('/vendor/libs/@form-validation/popular.js') }}></script>
    <script src={{ asset('/vendor/libs/@form-validation/bootstrap5.js') }}></script>
    <script src={{ asset('/vendor/libs/@form-validation/auto-focus.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Main JS -->
    <script src={{ asset('/js/main.js') }}></script>


    <!-- Page JS -->
    <script src={{ asset('/js/pages-auth.js') }}></script>

</body>

</html>
