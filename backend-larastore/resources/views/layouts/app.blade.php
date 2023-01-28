<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,
        shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/img/shop-2.png') }}" type="image/x-icon">

        <title>{{ $title ?? config('app.name') }} - LaraStore Admin</title>

        {{-- Custom fonts for this template --}}
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        {{-- Custom styles for this template --}}
        <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">

        <style>
            .form-control:focus {
                color: #6e707e;
                background-color: #fff;
                border-color: #375dce;
                outline: 0;
                box-shadow: none;
            }

            .form-group label {
                font-weight: bold;
            }

            #wrapper #content-wrapper {
                background-color: #e2e8f0;
                width: 100%;
                overflow-x: hidden;
            }

            .card-header {
                padding: .75rem 1.25rem;
                margin-bottom: 0;
                background-color: #4e73de;
                border-bottom: 1px solid #e3e6f0;
                color: white;
            }
        </style>

        {{-- JQuery --}}
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>

        {{-- Sweet Alert --}}
        <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>


    </head>

    <body id="page-top">
        
        {{-- Page Wrapper --}}
        <div id="wrapper">

            {{-- Sidebar --}}
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                {{-- Sidebar - Brand --}}
                <a href="{{ route('admin.dashboard.index') }}" class="sidebar-brand d-flex align-items-center justify-content-center">

                    <div class="sidebar-brand-icon">
                        <i class="fas fa-store-alt"></i>
                    </div>

                    <div class="sidebar-brand-text mx-3">
                        LARASTORE
                    </div>

                </a>

                {{-- Divider --}}
                <hr class="sidebar-divider my-0">

                {{-- Nav Item - Dashboard --}}
                <li class="nav-item {{ Request::is('admin/dashboard*') ? ' active' : '' }}">
                    
                    <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                    
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>DASHBOARD</span>

                    </a>

                </li>

                {{-- Divider --}}
                <hr class="sidebar-divider">

                {{-- Heading --}}
                <div class="sidebar-heading">
                    PRODUCTS
                </div>

                {{-- Nav Item - Pages Collapse Menu --}}
                <li class="nav-item {{ Request::is('admin/category*') ? ' active' : '' }} {{ Request::is('admin/product*') ? ' active': '' }}">
                
                    <a class="nav-link collapsed"href="#"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-shopping-bag"></i>
                        <span>PRODUCTS</span>
                    </a>

                    <div id="collapseTwo" class="collapse {{ Request::is('admin/category*' ? ' show' : '') }} {{ Request::is('admin/product*') ? ' show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">CATEGORY & PRODUCTS</h6>
                            <a href="{{ route('admin.category.index') }}" class="collapse-item {{ Request::is('admin/category*') ? ' active' : '' }}">CATEGORY</a>
                            <a href="{{ route('admin.product.index') }}" class="collapse-item {{ Request::is('admin/product*') ? ' active' : '' }}">PRODUCTS</a>
                        </div>

                    </div>

                </li>

                <div class="sidebar-heading">
                    ORDERS
                </div>

                <li class="nav-item {{ Request::is('admin/order*') ? ' active' : '' }}">
                
                    <a href="{{ route('admin.order.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>ORDERS</span>
                    </a>

                </li>

                <li class="nav-item {{ Request::is('admin/customer*') ? ' active' : '' }}">
                
                    <a href="{{ route('admin.customer.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>CUSTOMERS</span>
                    </a>

                </li>

                <li class="nav-item {{ Request::is('admin/slider*') ? ' active' : '' }}">
                
                    <a href="{{ route('admin.slider.index') }}" class="nav-link">
                        <i class="fas fa-laptop"></i>
                        <span>SLIDERS</span>
                    </a>

                </li>

                <li class="nav-item {{ Request::is('admin/profile*') ? ' active' : '' }}">
                
                    <a href="{{ route('admin.profile.index') }}" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        <span>PROFILE</span>
                    </a>

                </li>

                <li class="nav-item {{ Request::is('admin/user*') ? ' active' : '' }}">
                
                    <a href="{{ route('admin.user.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>USERS</span>
                    </a>

                </li>

                {{-- Divider --}}
                <hr class="sidebar-divider d-none d-md-block">

                {{-- Sidebar Toggler (Siderbar) --}}
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            {{-- End of Sidebar --}}

            {{-- Content Wrapper --}}
            <div id="content-wrapper" class="d-flex flex-column">

                {{-- Main Content --}}
                <div id="content">

                    {{-- Topbar --}}
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        {{-- Sidebar Toggle (Topbar) --}}
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        {{-- Topbar Navbar --}}
                        <ul class="navbar-nav ml-auto">

                            <div class="topbar-divider d-none d-sm-block"></div>

                            {{-- Nav Item - User Information --}}
                            <li class="nav-item dropdown no-arrow">
                                <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                        {{ auth()->user()->name }}
                                    </span>

                                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="img-profile rounded-circle">

                                </a>

                                {{-- Dropdown - User Information --}}
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    LOGOUT
                                    </a>
                                </div>

                            </li>

                        </ul>

                    </nav>
                    {{-- End of Topbar --}}

                    {{-- Begin Page Content --}}
                    @yield('content')
                    {{-- ./container-fluid --}}

                </div>
                {{-- End of Main Content --}}

                {{-- Footer --}}
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyrights. All rights reserved &copy; 2023 LaraStore</span>
                        </div>
                    </div>
                </footer>
                {{-- End of Footer --}}

            </div>
            {{-- End of Content Wrapper --}}

        </div>
        {{-- End of Page Wrapper --}}

        {{-- Scroll to Top Button --}}
        <a href="#page-top" class="scroll-to-top rounded">
            <i class="fas fa-angle-up"></i>
        </a>

        {{-- Logout Modal --}}
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Are you sure you want to leave?
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Please select "Logout" below to end the current session.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-primary">Logout</a>
                            <form action="{{ route('logout') }}" id="logout-form" style="display: none;" method="POST">
                            
                                @csrf
                            
                            </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bootstrap Core Javascript --}}
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>

        {{-- Core plugin Javascript --}}
        <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        {{-- Custom script for all pages --}}
        <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

        {{-- Page level plugins --}}
        <script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>

        {{-- Page level custom scripts --}}
        <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>

        <script>
            // Sweetalert for success or error messages
            @if (session()->has('success'))

            swal({
                type: "success",
                icon: "success",
                title: "SUCCESS",
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false,
                showCancleButton: false,
                buttons: false,
            });

            @elseif (session()->has('error'))

            swal({
                type: "error",
                icon: "error",
                title: "FAILED",
                text: {{ session('error') }},
                timer: 1500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
                
            @endif
        </script>

    </body>

</html>