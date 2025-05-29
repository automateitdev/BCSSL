<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadre Officers Co-operative Society Limited</title>
 <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    @include('layouts.member.partials.styles')




</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div> --}}

        <!-- Navbar -->
        @include('layouts.member.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        {{-- <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('layouts.member.partials.left_container')
        </aside> --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper p-4" id="app"  style="width:100;margin:0px;">

            {{ $slot }}
        </div>
        @include('layouts.member.partials.footersection')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('layouts.member.partials.scripts')


</body>

</html>
