<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" sizes="130x130" type="image/png" href="{{ asset('img/logo/icone2.png') }}">
    <title>
        ArWorld
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="g-sidenav-show bg-[#fbfafa]">

    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main" style="overflow: hidden;">
        <div class="sidenav-header" style="margin-bottom:20%; margin-top:10%">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{ route('home') }}" >
                <img src="{{ asset('img/logo/logo2.png') }}" class="navbar-brand-img h-400 mx-auto d-block" alt="main_logo" style="transform: scale(4.0); ">
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link  {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='#F5F5F5';"
               onmouseout="this.style.backgroundColor='white'">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <title>office</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-1869.000000, -293.000000)" fill="{{ request()->routeIs('home') ? '#FF4438' : '#FFC107' }}" fill-rule="nonzero">
                        <g transform="translate(1716.000000, 291.000000)">
                        <g id="office" transform="translate(153.000000, 2.000000)">
                        <img src="{{ asset('img/icone/vue.svg') }}" width="17px" height="20px">
                        </g>
                        </g>
                    </g>
                    </g>
                </svg>
                </div>
                <span class="nav-link-text ms-1">Vue d'ensemble</span>
            </a>
        </li>

        @if (session('utilisateur')->admin == 1)
            <li class="nav-item">
                <a class="nav-link  {{ request()->routeIs('statistique') ? 'active' : '' }}" href="{{ route('statistique') }}" onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='#F5F5F5';"
                onmouseout="this.style.backgroundColor='white'">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <title>shop</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-1716.000000, -439.000000)" fill="{{ request()->routeIs('statistique') ? '#FF4438' : '#FFC107' }}" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                            <g transform="translate(0.000000, 148.000000)">
                            <img src="{{ asset('img/icone/stat.svg') }}" width="17px" height="20px">
                            </g>
                            </g>
                        </g>
                        </g>
                    </svg>
                    </div>
                    <span class="nav-link-text ms-1">Statistique</span>
                </a>
            </li>
        @endif

        <!-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('historique') ? 'active' : '' }}" href="" onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='#F5F5F5';"
               onmouseout="this.style.backgroundColor='white'">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <title>credit-card</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-2169.000000, -745.000000)" fill="{{ request()->routeIs('historique') ? '#FF4438' : '#FFC107' }}" fill-rule="nonzero">
                        <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(453.000000, 454.000000)">
                        <img src="{{ asset('img/icone/historique.svg') }}" width="17px" height="20px">
                        </g>
                        </g>
                    </g>
                    </g>
                </svg>
                </div>
                <span class="nav-link-text ms-1">Historique</span>
            </a>
        </li> -->
        <li class="nav-item mt-3">
            <br>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#ModalProfil"
               onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='#F5F5F5';"
               onmouseout="this.style.backgroundColor='white'">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg width="12px" height="12px" viewBox="0 0 46 42" xmlns="http://www.w3.org/2000/svg">
                        <title>Profile</title>
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(-1717 -291)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716 291)">
                                    <g transform="translate(1 0)">
                                        <img src="{{ asset('img/icone/profil.svg') }}" width="17px" height="20px">
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Profil</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  hover:text-primary" href="{{ route('deco') }}" onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='#F5F5F5';"
               onmouseout="this.style.backgroundColor='white'">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg width="12px" height="20px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>spaceship</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                        <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(4.000000, 301.000000)">
                        <img src="{{ asset('img/icone/logout.svg') }}" width="17px" height="20px">
                        </g>
                        </g>
                    </g>
                    </g>
                </svg>
                </div>
                <span class="nav-link-text ms-1">Déconnexion</span>
            </a>
        </li>
        </ul>

        <br>
        <br>
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">

    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Bienvenue</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vivez l'expérience ArWorld</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $pageTitle }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">

                @if (str_ends_with($pageTitle, 'Accueil'))
                    <form method="get" action="{{ route('home') }}" class="d-flex">
                        @csrf
                        <input  type="text" name="recherche" class="form-control" placeholder="Recherche (client, campagne)">
                    </form>
                @endif

                <img src="{{ asset('img/icone/search.svg') }}" width="25px" height="auto" style="margin-left: 10px;" class="me-2" alt="recherche">
                <!-- recherche -->
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/icone/bell.svg') }}" class="cursor-pointer" width="24px" height="auto" alt="Notifications">


                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <h6>Notification</h6>

                    </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <br>
    <!-- End Navbar -->

    @yield('content')


    <!-- End content -->

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

</body>

</html>
