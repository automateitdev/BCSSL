
<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title','Deshboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <!-- CSRF Token -->
       <meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @include('layouts.partials.style')
</head>

<body>

    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container"  id="app">
        <!-- sidebar menu area start -->
        @include('layouts.partials.sidebar')
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            @include('layouts.partials.header-area')
            <!-- header area end -->
            <!-- page title area start -->
            @include('layouts.partials.page-title-area')
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- sales report area start -->
                <div class="sales-report-area mt-5 mb-5">
                    {{ $slot }}
                </div>

                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
      @include('layouts.partials.footer-area')
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    @include('layouts.partials.offset-area')
    <!-- offset area end -->
    @include('layouts.partials.script')
</body>

</html>
